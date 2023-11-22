# get rid of other directories
mv public_html ../
rm ./* -r
mv ../public_html/* .

# strip down to only production files
rm ./board/testenv -r
rm ./board/testenvFiles -r
