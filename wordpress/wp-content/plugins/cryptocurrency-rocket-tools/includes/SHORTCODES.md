### Price List

**[Online Demo](http://crtools.liberteam.org/#pricelist)**

To show the Price List add a shortcode on your page.

#### Shortcodes

`[crtools-pricelist]`

`[crtools-pricelist coin="BTC,ETH" fiat="USD,EUR"]`

`[crtools-pricelist limit="20" fiat="USD,EUR"]`

`[crtools-pricelist limit="0"]`

`[crtools-pricelist cols="logo,symbol,price,change"]`

#### Parameters

**coin** - list of cryptocurrencies, separated by commas. If **limit** is set, then **coin** will be ignored.

**fiat** - list of currencies, separated by commas. (Default: all currencies)

**limit** - displays a certain amount of top cryptocurrency by market capitalization. (Default: 10; if 0, then displays all)

**cols** - list of table columns, separated by commas. (Default: "logo,symbol,name,price,change").


##

### Table

**[Online Demo](http://crtools.liberteam.org/#table)**

To show the Table add a shortcode on your page.

#### Shortcodes

`[crtools-table coin="BTC,ETH,XRP,XMR,LTC" fiat="USD,EUR" cols="price,cap,supply,volume,change" search="false" pagination="10,20,30"]`

`[crtools-table coin="BTC" cols="price,change"]`

`[crtools-table]`

#### Parameters

**coin** - list of cryptocurrencies, separated by commas. (Default: all cryptocurrencies)

**fiat** - list of currencies, separated by commas. (Default: all currencies)

**cols** - list of table columns, separated by commas. (Default: "price,cap,supply,volume,change"). **Number** and **Name** are required.

**pagination** - show entries, separated by commas. (Default: "10,25")

**search** - displays search field. (Default: "true")

#### Table columns

**number** - Number

**name** - Name

**price** - Prices

**cap** - Market Capitalizations

**supply** - Circulating Supply

**volume** - Volume 24H

**change** - % Change 24H

**graph** - Price Graph 7D (temporary moved, will come back soon).


##

### Graph

**[Online Demo](http://crtools.liberteam.org/#graph)**

To show the Graph add a shortcode on your page.

The graph can display only USD prices, due it uses historical data from [CoinCap API](http://coincap.io/).

#### Shortcodes

`[crtools-graph coin="BTC" period="1M,1Y"]`

`[crtools-graph]`

#### Parameters

**coin** - cryptocurrency. (Default: BTC)

**period** - list of historical data display periods. (Default: "1D, 1W, 1M, 3M, 6M, 1Y"). Available: 1D,1W,1M,3M,6M,1Y


##

### Converter

**[Online Demo](http://crtools.liberteam.org/#converter)**

To show the Converter add a shortcode on your page.

#### Shortcodes

`[crtools-converter from="BTC,ETH" to="USD" other="EUR,RUB,GBP"]`

`[crtools-converter from="BTC"]`

`[crtools-converter]`

#### Parameters

**from** - list of cryptocurrencies or currencies, separated by commas. (Default: all cryptocurrencies)

**fiat** - list of cryptocurrencies or currencies, separated by commas. (Default: all currencies)
