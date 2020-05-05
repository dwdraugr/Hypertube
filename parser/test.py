import json
import pprint
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
        self.items.append(item)
        # print(self.item_num)
        # print(item)
        self.item_num += 1
        if self.item_num > 40:
            reactor.stop()
            return self.items

    def return_items(self, result):
        return self.items


def just_return_this_shit():
    runner = MyLittleCrawlerRunner()
    # spider = LegitTorrentSpider('hubble')
    deferred = runner.crawl(LegitTorrentSpider, 'hubble')
    runner.crawl(ArchiveOrgSpider, 'hubble')
    # deferred.addCallback(return_spider_output)
    runner.join().addBoth(lambda _: reactor.stop())
    return deferred


if __name__ == '__main__':
    pp = pprint.PrettyPrinter(indent=2, width=80)
    d = just_return_this_shit()
    reactor.run()
    pp.pprint(d.result)

