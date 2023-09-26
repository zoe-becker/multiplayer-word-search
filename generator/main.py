import os
import sys
from word_search_generator import WordSearch

sys.path.insert(0, os.path.dirname(__file__))


def application(environ, start_response):
    start_response('200 OK', [('Content-Type', 'text/plain')])
    puzzle = WordSearch("dog, cat, pig, horse, donkey, turtle, goat, sheep, unicorn")
    response = str(puzzle)
    return [response.encode()]
