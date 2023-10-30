import os
import sys
import random
import json
from urllib.parse import parse_qs
from word_search_generator import WordSearch

sys.path.insert(0, os.path.dirname(__file__))

# THEME = 'nicki.json'

def application(environ, start_response):
    start_response('200 OK', [('Content-Type', 'text/plain')])
    wordBank = random_words(environ)
    puzzle = WordSearch(wordBank)
    response = str(puzzle.to_json())
    return [response.encode()]


def get_theme_from_url(query_string):
    query_dict = parse_qs(query_string)
    theme_list = query_dict.get('theme')
    return theme_list[0]

def random_words(environ):
    THEME = get_theme_from_url(environ['QUERY_STRING'])
    print(THEME)
    if THEME is None:
        return "Theme not found"

    file_path = os.path.join(os.path.dirname(__file__), f'../themes/{THEME}.json')
    print(file_path)
    words = load_json(file_path)
    if words is None:
        return "Failed to load JSON data"

    wordBank = random.sample(words["words"], min(9, len(words["words"])))
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
    return None