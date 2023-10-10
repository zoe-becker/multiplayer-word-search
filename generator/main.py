import os
import sys
import random
from wordDictionary import words
from word_search_generator import WordSearch

sys.path.insert(0, os.path.dirname(__file__))


def application(environ, start_response):
    start_response('200 OK', [('Content-Type', 'text/plain')])
    wordBank = random_words()
    puzzle = WordSearch(wordBank)
    response = str(puzzle.to_json())
    return [response.encode()]


def random_words():
    wordBank= []
    word = random.sample(range(0, len(words["words"])), 9)
    random.sample(range(0, len(words["words"])), 9)

    for num in word:
        wordBank.append(words["words"][num])
        
    result = ', '.join(map(str, wordBank))
    return result
