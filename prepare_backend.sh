# move backend directories into one folder
mkdir ../word-search
mv ./generator ../word-search
mv ./config ../word-search
mv ./utilities ../word-search
rm ./* -r
mv ../word-search/* .

