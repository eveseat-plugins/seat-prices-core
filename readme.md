# seat-prices-core

## Installation
You don't need to install this plugin directly, it will be installed automatically alongside plugins depending on 
seat-prices-core. However, you might want to install one or multiple of the price providers listed under [available 
price providers](#available-price-providers) in order to get more price sources.

## Available Price Providers
| Price Provider          | Description                                                                                                      | Plugin                                                |
|-------------------------|------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------|
| SeAT Prices             | All kinds of prices the SeAT core includes. Included per default.                                                | recursivetree/seat-prices-core (included per default) |
| EvePraisal              | Uses the API of an evepraisal instance to get prices.                                                            | recursivetree/seat-prices-evepraisal                  |
| Item Manufacturing Time | Exotic price provider that values items based on the time it takes to build them. Part of seat-alliance-industry | recursivetree/seat-alliance-industry                  |
| Fuzzwork                | Prices from fuzzwork market data for the seat-prices-core price provider system.                                 | cryptatech/seat-prices-fuzzwork                       | 
| Janice                  | Prices from janice for the seat-prices-core price provider system.                                               | cryptatech/seat-prices-janice                         |

## Deprecated Price Providers
| Price Provider          | Description                                                                                                      | Plugin                                                |
|-------------------------|------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------|
| EveMarketer             | Uses the evemarketer.com API to get prices                                                                       | recursivetree/seat-prices-evemarketer                 |

## Developer Documentation
The developer documentation can be found [here](developer_documentation.md).