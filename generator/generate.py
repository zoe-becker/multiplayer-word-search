# this file is responsible for generating a word search
# it takes as an argument the path to a theme file to generate from
# and the number of words in generate

import sys
import random
import json
from word_search_generator import WordSearch
from word_search_generator.mask.shapes import Heart
from word_search_generator.mask.shapes import Star

# words is the list of words to use when generating the word search
def fetchWordSearch(themeData, count, difficulty, size1, shape):
    words = random_words(themeData["words"], count)        
    puzzle = WordSearch(words, level=difficulty, size=size1)
    
    if shape == "star":
        puzzle.apply_mask(Star())
    elif shape == "heart":
        puzzle.apply_mask(Heart())
    else:
        pass
    
    response = str(puzzle.to_json())
    return response

def random_words(words, count):
    wordBank = random.sample(words, min(count, len(words)))
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

# print result of generation
print(fetchWordSearch(load_json(sys.argv[1]), int(sys.argv[2]),int(sys.argv[3]),int(sys.argv[4]), str(sys.argv[5])))