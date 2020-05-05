from scrapy.item import Item, Field


class TorrentItem(Item):
    title = Field()
    link = Field()
    description = Field()
    date = Field()
