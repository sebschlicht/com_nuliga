# Joomla! NuLiga Component

This is a Joomla! component to manage NuLiga teams and tables.
The component supports Joomla! 3.0 and higher.

While the component only allows to manage NuLiga entities at the moment, you can use the [NuLiga plugin](https://github.com/sebschlicht/plg_nuliga) to display NuLiga tables in articles, for example.

## Requirements

Apparently, PHP version 5.x is required at the moment.
This limitation comes from the HTML DOM parser library in use.
Reportedly you can simply replace the [parser file](https://github.com/sebschlicht/com_nuliga/blob/master/admin/libraries/nuliga/parser/simple_html_dom.php) with [its newest version](https://sourceforge.net/projects/simplehtmldom/files/simplehtmldom/1.9/) to support PHP 7.x.

## License

This component is licensed under the MIT License; see [LICENSE](https://github.com/sebschlicht/com_nuliga/blob/master/LICENSE).

## Installation

Simply download the latest [release](https://github.com/sebschlicht/com_nuliga/releases) and install the package via the extension manager.
The extension supports the update manager, thus you will be notified about updates by your Joomla! instance automatically.

## Usage

Go to `Components > NuLiga` and add the teams that you would like to display tables for.
The team fields should be pretty self-explanatory.

Then use the [plugin](https://github.com/sebschlicht/plg_nuliga) to display a NuLiga table of a team in an article, for example.

## Acknowledgments

This component is based on the [*Simple HTML DOM*](https://sourceforge.net/projects/simplehtmldom/) parser.
*Simple HTML DOM* is licensed under the MIT License.
