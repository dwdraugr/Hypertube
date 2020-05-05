import scrapy
import datetime
from scrapy.loader import ItemLoader
from item import TorrentItem


class ArchiveOrgSpider(scrapy.Spider):
    name = 'archive_org'
    allowed_domain = ['archive.org']

    def __init__(self, argv, torrents_list):
        self.start_urls = ['https://archive.org/details/movies?and%5B%5D={}&sin=&sort=&page=1'
                               .format(argv)]
        self.torrents_list = torrents_list

    def parse(self, response):
        elements = response.xpath(".//div[@class='item-ia' and @data-mediatype='movies']")
        elements = elements.css(".C234")
        elements = elements.xpath('./div/a')
        for element in elements:
            loader = ItemLoader(item=TorrentItem(), selector=element)
            element_item = loader.load_item()
            yield response.follow(element, self.parse_torrent_page,
                                  meta={'torrent_item': element_item})

        for a in response.css(".page-next"):
            yield response.follow(a, self.parse)

    def parse_torrent_page(self, response):
        torrent_item = response.meta['torrent_item']
        loader = ItemLoader(item=torrent_item, response=response)
        loader.add_css('title', "h1 .breaker-breaker::text")
        loader.add_css('description', "#descript::text")
        loader.add_value('link', "https://archive.org{}"
                         .format(response.css(".item-download-options div.format-group:nth-last-child(2) a::attr(href)")
                                 .get()))
        loader.add_value('date', str(datetime.datetime.strptime(response.css("time::text").get(),
                                                                "%B %d, %Y")).split(sep=" ")[0])
        title = str(response.css("h1 .breaker-breaker::text").get())
        link = "https://archive.org{}".format(response.css(".item-download-options div.format-group:nth-last-child(2) "
                                                           "a::attr(href)").get())
        if link.endswith('.torrent'):
            self.torrents_list.append({
                'title': title,
                'description': response.css("#descript::text").get(),
                'link': link,
                'date': str(datetime.datetime.strptime(response.css("time::text").get(),
                                                       "%B %d, %Y")).split(sep=" ")[0]
            })
            yield loader.load_item()
        else:
            return
