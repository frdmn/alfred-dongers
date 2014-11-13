alfred-dongers (WIP)
====================

Alfred workflow to quickly browse through dongers (໒( ” •̀ ᗜ •́ ” )७ for example) via [dongerlist.com](http://dongerlist.com/).

![](http://up.frd.mn/ul1QZ.png)

![](http://up.frd.mn/GWMor.png)

![](http://up.frd.mn/9ABg2.png)

## Usage

Show _all_ available dongers:

`dongers`  

---

List available categories to filter:

`dongers list`

---

Show dongers from specific category:

`dongers <category>` 

## Installation

1. Download the raw [`alfred-dongers.alfredworkflow`](https://github.com/frdmn/alfred-dongers/releases) file from GitHub releases
1. Double click to execute and import that workflow into Alfred
1. To speed up the search queries we're going to cache the "donger library" and store it locally as JSON. Run the following at least once, or set a cronjob:  
  `php parser/parser.php > ~/.donger.cache`

## Version

0.1.0

## License

[WTFPL](LICENSE)
