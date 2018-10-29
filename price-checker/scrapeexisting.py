import scrape
import json

with open('/var/www/html/comroads/public/content/prices-heb.json') as f:
    data = json.load(f)

def priceCheck():
    for key in data:
        print(key)
        if data[key]['ebay']['enabled']:
            print("ebay")                
            result = scrape.scrapeEbay(data[key]['ebay']['endurl'])
            if result != None:
                data[key]['ebay']['price'] = result
            else: data[key]['ebay']['price'] = "Not available"

    for key in data:
        if data[key]['lightinthebox']['enabled']:
            print("lightinthebox")                
            result = scrape.scrapeLightInTheBox(data[key]['lightinthebox']['endurl'])
            if result != None:
                data[key]['lightinthebox']['price'] = result
            else: data[key]['lightinthebox']['price'] = "Not Available"

    for key in data:
        if data[key]['aliexpress']['enabled']:
            print("aliexpress")
            result = scrape.scrapeAli(data[key]['aliexpress']['endurl'])
            if result != None:
                data[key]['aliexpress']['price'] = result
            else: data[key]['aliexpress']['price'] = "Not Available"



                
    with open('/var/www/html/comroads/public/content/prices-heb.json', 'w') as outfile:
        json.dump(data, outfile)