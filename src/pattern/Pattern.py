#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import json

# Make it work for Python 2+3 and with Unicode
import io
try:
    to_unicode = unicode
except NameError:
    to_unicode = str

print("[Build DOM pattern]\n")
prefix = input("Prefix: ")
# Define data
data = {
    "prefix": prefix,
    "DOMPath": {
        "manufacturer_id": input("Manufacturer id: "),
        "products_name": input("Name: "),
        "products_model": input("Model: "),
        "products_ean": input("EAN: "),
        "products_description": input("Description: "),
        "products_short_description": input("Short description: "),
        "products_price": input("Price: "),
        "products_weight": input("Weight: "),
        "products_image": []

    }
}

print("[ImagePath \"e\" to continue!]\n")
index = 0
while (True):
    path = input("ImagePath: ")
    if (path == "e"):
        break
    data["DOMPath"]["products_image"].append(path)
    index += 1
print("Write " + prefix + ".json\n")
# Write JSON file
with io.open(prefix + '.json', 'w', encoding='utf8') as outfile:
    str_ = json.dumps(data, indent=2, sort_keys=True, separators=(',', ': '),
                      ensure_ascii=False)
    outfile.write(to_unicode(str_))
