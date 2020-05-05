import pprint
from time import sleep
from qbittorrent import Client
from scrapy import signals
from scrapy.crawler import CrawlerRunner
from twisted.internet import reactor
from spiders.archive_org import ArchiveOrgSpider
from spiders.legittorrent import LegitTorrentSpider


class MyLittleCrawlerRunner(CrawlerRunner):
    def __init__(self, settings=None):
        super().__init__(settings=None)
        self.items = []
        self.item_num = 0

    def crawl(self, crawler_or_spidercls, *args, **kwargs):
        crawler = self.create_crawler(crawler_or_spidercls)
        crawler.signals.connect(self.item_scraped, signals.item_scraped)
        dfd = self._crawl(crawler, *args, **kwargs)
        dfd.addCallback(self.return_items)
        return dfd

    def item_scraped(self, item, response, spider):
        if item['link'][0].endswith('.torrent'):
            self.items.append(item)
        else:
            return
        self.item_num += 1
        if self.item_num == 40:
            reactor.stop()

    def return_items(self, result):
        return self.items


def just_return_this_shit():
    runner = MyLittleCrawlerRunner()
    runner.crawl(ArchiveOrgSpider, 'hubble')
    deferred_lib = runner.crawl(LegitTorrentSpider, 'hubble')
    runner.join().addBoth(lambda _: reactor.stop())
    return deferred_lib


if __name__ == '__main__':
    pp = pprint.PrettyPrinter(indent=1, width=100)
    d = just_return_this_shit()
    reactor.run()
#     qb = Client("http://vo-c2.21-school.ru:8888")
#     qb.login('admin', 'adminadmin')
#     for dd in d.result:
#         qb.download_from_link(dd['link'][0])
#         sleep(2)
    pp.pprint(d)
    print('===BIB===')
