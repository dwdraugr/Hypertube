import scrapy
from scrapy.loader import ItemLoader
from item import TorrentItem


class LegitTorrentSpider(scrapy.Spider):
    name = 'legit_torrent'
    allowed_domain = ['legittorrents.info']

    def __init__(self, arg, torrents_list):
        self.start_urls = ['http://www.legittorrents.info/index.php?page=torrents&search={}&category=1&active=1'
                           .format(arg)]
        self.torrents_list = torrents_list

    def parse(self, response):
        torrents = response.css('table table table table a[title]')

        for torrent in torrents:
            torrent_page = torrent.css('a::attr(href)').get()
            loader = ItemLoader(item=TorrentItem(), selector=torrent)
            torrent_item = loader.load_item()
            yield response.follow(torrent_page, self.parse_torrent_page,
                                  meta={'torrent_item': torrent_item})

        for a in response.xpath(".//form[@name='change_pagepages']/span[last() - 1]/a"):
            yield response.follow(a, self.parse)

    def parse_torrent_page(self, response):
        torrent_item = response.meta['torrent_item']
        table = response.css("table.lista[cellspacing='5']")
        rows = table.xpath("./tr/td[@class='lista']")
        loader = ItemLoader(item=torrent_item, response=response)
        loader.add_value('title', rows[0].css('::text').get())
        loader.add_value('link', "http://www.legittorrents.info/{}"
                         .format(str(rows[1].css('a::attr(href)').get())))
        loader.add_value('description', ''.join(rows[3].css('::text').getall()))
        loader.add_value('date', rows[8].css("time::attr(datetime)").get())

        self.torrents_list.append({
            'title': rows[0].css('::text').get(),
            'link': "http://www.legittorrents.info/{}"
                         .format(str(rows[1].css('a::attr(href)').get())),
            'description': ''.join(rows[3].css('::text').getall()),
            'date': rows[8].css("time::attr(datetime)").get()})

        yield loader.load_item()
