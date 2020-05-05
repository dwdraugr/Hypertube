from time import sleep

from flask import Flask, request
from flask import jsonify
from scrapy.crawler import CrawlerRunner
from spiders.legittorrent import LegitTorrentSpider
from spiders.archive_org import ArchiveOrgSpider

app = Flask('Scrape With Flask')
crawl_runner = CrawlerRunner()  # requires the Twisted reactor to run
  # store quotes
scrape_in_progress = False
scrape_complete = False


@app.route('/crawl')
def crawl_for_quotes():
    """
    Scrape for quotes
    """
    torrents_list = []
    if request.args.get('query') is None:
        return {
            'status': 'Query not found'
        }, 404

    scrape_in_progress = True
    # start the crawler and execute a callback when complete
    eventual = crawl_runner.crawl(LegitTorrentSpider, request.args.get('query'), torrents_list=torrents_list)
    eventual.addCallback(finished_scrape)
    eventual = crawl_runner.crawl(ArchiveOrgSpider, request.args.get('query'), torrents_list=torrents_list)
    eventual.addCallback(finished_scrape)
    while len(torrents_list) <= 35:
        sleep(2)  # pass загружает проц под сотню
    return jsonify(torrents_list)





@app.route('/stop')
def stop_crawl():
    crawl_runner.stop()
    return {
        'status': 'stop'
    }




def finished_scrape(null):
    """
    A callback that is fired after the scrape has completed.
    Set a flag to allow display the results from /results
    """
    global scrape_complete
    scrape_complete = True


@app.errorhandler(500)
def error(e):
    return e


if __name__ == '__main__':
    from sys import stdout
    from twisted.logger import globalLogBeginner, textFileLogObserver
    from twisted.web import server, wsgi
    from twisted.internet import endpoints, reactor

    # start the logger
    globalLogBeginner.beginLoggingTo([textFileLogObserver(stdout)])

    # start the WSGI server
    root_resource = wsgi.WSGIResource(reactor, reactor.getThreadPool(), app)
    factory = server.Site(root_resource)
    http_server = endpoints.TCP4ServerEndpoint(reactor, 9000)
    http_server.listen(factory)

    # start event loop
    reactor.run()
