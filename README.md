# SMWListProps

Extension for printing out all the different properties associated to a wiki page.

## Usage

* {{#SMWListProps:FULLPAGENAME|wikionly}}

If FULLPAGENAME is skipped, current pagename is considered.

If we define 'wikionly', only properties defined in the wiki (not [special ones](http://semantic-mediawiki.org/wiki/Help:Special_properties)) are printed.

Other parameters:

* values: show properties values
* raw: render properties values as raw or unformatted text

It's possible to change output
* sep=separator: defines a separator (default ,)
* sepvalues=separator: defines a separator in case of multiple values (default -)
* eqvalues=equal: define a property - value linking value (default :)

