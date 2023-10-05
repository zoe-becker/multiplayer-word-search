mv tempAppHolder/* /home/j1jjujqhggs6/public_html/word-search-generator/generator
mv tempAppHolder/.htaccess /home/j1jjujqhggs6/public_html/word-search-generator/generator
rm tempAppHolder -r
source /home/j1jjujqhggs6/virtualenv/public_html/word-search-generator/generator/3.7/bin/activate
cd /home/j1jjujqhggs6/public_html/word-search-generator/generator 
pip install . 
touch tmp/restart.txt