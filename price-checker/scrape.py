import requests, re, time, random
from bs4 import BeautifulSoup
from fake_useragent import UserAgent
from urllib.parse import urlparse
import json
import sys

def scrapeAli(itemUrl):
    parsed = urlparse(itemUrl)
    url = 'https://'+parsed.netloc+parsed.path
    #print('\n' + url)
    ua = UserAgent(fallback='Mozilla/5.0 (compatible; Googlebot/2.1; ')
    header = {'User-Agent': ua.random}
    metadata = {}
    res = requests.get(url, allow_redirects=True, headers=header)
    if res.status_code == 404:
        return None
    soup = BeautifulSoup(res.text, 'lxml')
    if soup.find('span', attrs={'itemprop': 'lowPrice'}) != None:
        metadata['price'] = "$" + soup.find('span', attrs={'itemprop': 'lowPrice'}).text.replace(",", "")
    else:
        metadata['price'] = "$" + soup.find('span', attrs={'itemprop': 'price'}).text.replace(",", "")
    return metadata


def scrapeEbay(itemUrl):
    parsed = urlparse(itemUrl)
    url = 'https://'+parsed.netloc+parsed.path
    ua = UserAgent(fallback='Mozilla/5.0 (compatible; Googlebot/2.1; ')
    header = {'User-Agent': ua.random}
    meta = {}
    res = requests.get(url, allow_redirects=True, headers=header)
    if res.status_code == 404:
        return None
    soup = BeautifulSoup(res.text, 'lxml')
    if soup.find('span', attrs={'itemprop': 'price'}) != None:
        meta['price'] = soup.find('span', attrs={'itemprop': 'price'}).text.replace("US ", "")
    if soup.find('span', attrs={'id': 'mm-saleDscPrc'}) != None:
        meta['price'] = soup.find('span', attrs={'id': 'mm-saleDscPrc'}).text.replace("US ", "")
    return meta

def scrapeLightInTheBox(itemUrl):
    parsed = urlparse(itemUrl)
    url = 'https://'+parsed.netloc+parsed.path+"?"+parsed.query
    ua = UserAgent(fallback='Mozilla/5.0 (compatible; Googlebot/2.1; ')
    header = {'User-Agent': ua.random}
    meta = {}
    res = requests.get(url, allow_redirects=True, headers=header)
    if res.status_code == 404:
        return None
    soup = BeautifulSoup(res.text, 'lxml')
    if soup.find('div', attrs={'class': 'pro-n-f'}) is None:
        meta['price'] = soup.find('strong', attrs={'itemprop': 'price'}).text.replace("\r", "").replace("\n", "").replace("\t", "")
    else:
         return None
    return meta