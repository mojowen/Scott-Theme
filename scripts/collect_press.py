#!/usr/bin/env python3
"""
collect_press.py — manage the press clippings in stuff/press.json.

Usage:
  ./scripts/collect_press.py add <url> [--title T] [--outlet O] [--date YYYY-MM-DD] [--quote Q]
      Fetches the page, pulls og:title / <title> and og:site_name automatically,
      then appends the clipping. Any flag overrides what was scraped.

  ./scripts/collect_press.py list
  ./scripts/collect_press.py remove <index-from-list | url>

Examples:
  ./scripts/collect_press.py add https://someblog.com/nice-things-about-scott
  ./scripts/collect_press.py add https://news.site/story --quote "Genius work." --date 2025-03-01
"""

import argparse
import json
import re
import sys
import urllib.request
from datetime import date
from pathlib import Path

PRESS_FILE = Path(__file__).resolve().parent.parent / "stuff" / "press.json"
UA = {"User-Agent": "Mozilla/5.0 (press-collector)"}


def load():
    if PRESS_FILE.exists():
        return json.loads(PRESS_FILE.read_text(encoding="utf-8"))
    return []


def save(clippings):
    clippings.sort(key=lambda c: c.get("date") or "", reverse=True)
    PRESS_FILE.write_text(
        json.dumps(clippings, indent="\t", ensure_ascii=False) + "\n",
        encoding="utf-8",
    )


def scrape(url):
    """Pull title/outlet from a page's meta tags. Returns (title, outlet)."""
    req = urllib.request.Request(url, headers=UA)
    try:
        with urllib.request.urlopen(req, timeout=15) as resp:
            html = resp.read(512 * 1024).decode("utf-8", errors="replace")
    except Exception as e:
        sys.exit(f"Could not fetch {url}: {e}\nAdd it manually with --title instead.")

    def meta(prop):
        m = re.search(
            r'<meta[^>]+(?:property|name)=["\']' + prop + r'["\'][^>]*content=["\']([^"\']+)',
            html, re.IGNORECASE)
        if not m:
            m = re.search(
                r'<meta[^>]+content=["\']([^"\']+)["\'][^>]*(?:property|name)=["\']'
                + prop + r'["\']', html, re.IGNORECASE)
        return m.group(1).strip() if m else None

    title = meta("og:title") or meta("twitter:title")
    if not title:
        m = re.search(r"<title[^>]*>(.*?)</title>", html, re.IGNORECASE | re.DOTALL)
        title = re.sub(r"\s+", " ", m.group(1)).strip() if m else None
    # Strip trailing site name often glued onto <title> ("Story — Outlet")
    outlet = meta("og:site_name")
    if not outlet and title and " — " in title:
        title, _, outlet = title.rpartition(" — ")
        title = title.strip()
    return title, outlet


def cmd_add(args):
    clippings = load()
    title, outlet = scrape(args.url) if not args.title else (args.title, None)
    if args.outlet:
        outlet = args.outlet
    entry = {
        "title": title or args.url,
        "outlet": outlet or "",
        "url": args.url,
        "date": args.date or date.today().isoformat(),
        "quote": args.quote or "",
    }
    if any(c.get("url") == args.url for c in clippings):
        sys.exit(f"Already collected: {args.url}")
    clippings.append(entry)
    save(clippings)
    print(f"Added [{len(load()) - 1}] {entry['date']} {entry['outlet'] or '—'} :: {entry['title']}")


def cmd_list(args):
    for i, c in enumerate(load()):
        print(f"[{i}] {c.get('date', '?')}  {c.get('outlet') or '—':20s}  {c.get('title', '')}")
        print(f"     {c.get('url', '')}")


def cmd_remove(args):
    clippings = load()
    if args.target.isdigit():
        removed = clippings.pop(int(args.target))
    else:
        matches = [c for c in clippings if c.get("url") == args.target]
        if not matches:
            sys.exit(f"No clipping with url {args.target}")
        removed = matches[0]
        clippings.remove(removed)
    save(clippings)
    print(f"Removed: {removed.get('title')}")


def main():
    p = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    sub = p.add_subparsers(dest="cmd", required=True)

    a = sub.add_parser("add", help="scrape a url and add it")
    a.add_argument("url")
    a.add_argument("--title", help="override scraped title")
    a.add_argument("--outlet", help="override scraped outlet")
    a.add_argument("--date", help="publication date YYYY-MM-DD (default: today)")
    a.add_argument("--quote", help="optional pull quote")
    a.set_defaults(func=cmd_add)

    l = sub.add_parser("list", help="show all clippings")
    l.set_defaults(func=cmd_list)

    r = sub.add_parser("remove", help="remove by index or url")
    r.add_argument("target")
    r.set_defaults(func=cmd_remove)

    args = p.parse_args()
    args.func(args)


if __name__ == "__main__":
    main()
