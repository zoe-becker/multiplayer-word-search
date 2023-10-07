from wordDictionary import words
import random


# wordBank= []

# word = random.sample(range(0, len(words["words"])), 9)
# print(word)

# random.sample(range(0, len(words["words"])), 9)
# print(len(words["words"]))


# for num in word:
#     wordBank.append(words["words"][num])
    
# result = ', '.join(map(str, wordBank))
# print(result)

def random_words():

    wordBank= []

    word = random.sample(range(0, len(words["words"])), 9)
    
    random.sample(range(0, len(words["words"])), 9)
    


    for num in word:
        wordBank.append(words["words"][num])
        
    result = ', '.join(map(str, wordBank))
    return result