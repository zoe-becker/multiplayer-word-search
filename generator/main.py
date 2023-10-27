import os
import sys
import random
import json
from word_search_generator import WordSearch

sys.path.insert(0, os.path.dirname(__file__))

THEME = 'nicki.json'

def application(environ, start_response):
    start_response('200 OK', [('Content-Type', 'text/plain')])
    wordBank = random_words()
    puzzle = WordSearch(wordBank)
    response = str(puzzle.to_json())
    return [response.encode()]


def random_words():
    file_path = f'c:/cs3398 downloads/htdocs/word-search-generator/generator/themes/{THEME}'
    words = load_json(file_path)
    wordBank= []
    word = random.sample(range(0, len(words["words"])), 9)
    random.sample(range(0, len(words["words"])), 9)

    for num in word:
        wordBank.append(words["words"][num])
        
    result = ', '.join(map(str, wordBank))
    return result


def load_json(file_path):
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            data = json.load(f)
        return data
    except json.JSONDecodeError as e:
        print(f"Error decoding JSON: {e}")
    except FileNotFoundError:
        print("The file was not found.")
    except Exception as e:
        print(f"An error occurred: {e}")
