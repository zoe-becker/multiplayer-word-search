from word_search_generator import WordSearch
from word_search_generator.config import level_dirs, max_puzzle_words
from word_search_generator.generate import no_duped_words
from word_search_generator.utils import get_random_words
from word_search_generator.word import Direction, Word, Wordlist


def setup_words():
    BAT = Word("bat")
    BAT.start_row = 0
    BAT.start_column = 0
    BAT.direction = Direction.SE
    BAT.secret = False
    PLACED_WORDS.add(BAT)

    CAB = Word("cab")
    CAB.start_row = 4
    CAB.start_column = 2
    CAB.direction = Direction.SE
    CAB.secret = False
    PLACED_WORDS.add(CAB)

    RAT = Word("rat")
    RAT.start_row = 0
    RAT.start_column = 4
    RAT.direction = Direction.S
    RAT.secret = False
    PLACED_WORDS.add(RAT)


PLACED_WORDS: Wordlist = set()
setup_words()
PUZZLE = [
    ["B", "", "", "", "R"],
    ["", "A", "", "", "A"],
    ["", "", "T", "", "T"],
    ["", "", "", "", ""],
    ["", "", "C", "A", "B"],
]


def test_dupe_at_position_1():
    check = no_duped_words(PUZZLE, {word.text for word in PLACED_WORDS}, "A", (3, 3))
    assert check is False


def test_dupe_at_position_2():
    check = no_duped_words(PUZZLE, {word.text for word in PLACED_WORDS}, "A", (1, 3))
    assert check is False


def test_no_dupe_at_position():
    check = no_duped_words(PUZZLE, {word.text for word in PLACED_WORDS}, "Z", (1, 3))
    assert check is True


def test_puzzle_size_less_than_shortest_word_length():
    ws = WordSearch("DONKEY", size=5)
    assert ws.size == 7


def test_only_placed_words_in_key():
    w = ",".join(get_random_words(100))
    ws = WordSearch(w, size=5)
    assert all(word.direction for word in ws.placed_words)


def test_too_many_supplied_words():
    w = ",".join(get_random_words(100))
    ws = WordSearch(w, size=5)
    assert len(ws.words) != len(ws.placed_words)


def test_fit_all_words_with_plenty_of_space():
    for _ in range(10):
        ws = WordSearch("cat dog pig cow mule duck")
        assert len(ws.placed_words) == 6


def test_fit_all_words_with_plenty_of_space_and_secret_words():
    for _ in range(10):
        ws = WordSearch("cat dog pig", secret_words="cow mule duck")
        assert len(ws.placed_words) == 6


def test_too_many_words():
    ws = WordSearch(size=50)
    ws.random_words(100)
    ws.random_words(100, action="ADD")
    assert len(ws.placed_words) <= max_puzzle_words


def test_too_many_secret_words():
    ws = WordSearch(size=50)
    ws.random_words(100)
    ws.random_words(100, action="ADD", secret=True)
    assert len(ws.placed_words) <= max_puzzle_words


def test_secret_word_directions():
    words = "cat bat rat"
    level = 1  # right or down
    secret_words = "pig dog fox"
    secret_level = 7  # diagonals only
    ws = WordSearch(
        words, level=level, secret_words=secret_words, secret_level=secret_level
    )
    for w in ws.placed_secret_words:
        assert w.direction in level_dirs[secret_level]
