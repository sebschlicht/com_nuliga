#!/bin/bash
rm -f com_nuliga.zip
zip -q -9 -x "/.gitignore" -x "/.git/*" -x "/.idea/*" -x "/mkzip.sh" -x "/.mkzip.sh.swp" -x "/updates/*" -r com_nuliga.zip .

