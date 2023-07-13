import pytest

from word_search_generator.game.word_search import WordSearch
from word_search_generator.mask import shapes
from word_search_generator.word import Direction, Word


@pytest.fixture
def iterations():
    return 5


@pytest.fixture
def words():
    return "dog, cat, pig, horse, donkey, turtle, goat, sheep"


@pytest.fixture
def secret_words():
    # "tortoise" not included in because it is 8 characters long (everything else at 6)
    return "rabbit, mule, bunny, ram, kitten, puppy, foal"


@pytest.fixture
def ws(words):
    return WordSearch(words)


@pytest.fixture
def builtin_mask_shapes():
    return [eval(f"shapes.{shape}")() for shape in shapes.BUILTIN_MASK_SHAPES]


@pytest.fixture
def generator_test_puzzle():
    return [
        ["B", "", "", "", "R"],
        ["", "A", "", "", "A"],
        ["", "", "T", "", "T"],
        ["", "", "", "", ""],
        ["", "", "C", "A", "B"],
    ]


@pytest.fixture
def placed_words():
    BAT = Word("bat")
    BAT.start_row = 0
    BAT.start_column = 0
    BAT.direction = Direction.SE
    BAT.secret = False

    CAB = Word("cab")
    CAB.start_row = 4
    CAB.start_column = 2
    CAB.direction = Direction.SE
    CAB.secret = False

    RAT = Word("rat")
    RAT.start_row = 0
    RAT.start_column = 4
    RAT.direction = Direction.S
    RAT.secret = False
    return {BAT, CAB, RAT}


@pytest.fixture
def builtin_mask_shapes_output():
    return {
        "Circle": """# # # # # # # * * * * * * * # # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # # * * * * * * * # # # # # # #
""",
        "Club": """# # # # # # # # * * * * * # # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * # * * * # * * * * * # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
""",
        "Diamond": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
""",
        "Donut": """# # # # # # # * * * * * * * # # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * # # # * * * * * * * * *
* * * * * * * * # # # # # * * * * * * * *
* * * * * * * # # # # # # # * * * * * * *
* * * * * * * # # # # # # # * * * * * * *
* * * * * * * # # # # # # # * * * * * * *
* * * * * * * * # # # # # * * * * * * * *
* * * * * * * * * # # # * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # # * * * * * * * # # # # # # #
""",
        "Fish": """# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
* * * # # # # # # # * * * * * * # # # # #
# # * * * # # # * * * * * * * * * * # # #
# # # * * * # * * * * * * * * * * * * # #
# # # # * * * * * * * * * * * * * * * * #
# # # # * * * * * * * * * * * * * * * * #
# # # # # * * * * * * * * * * * * * * * *
# # # # # * * * * * * * * * * * * * * * *
# # # # # * * * * * * * * * * * * * * * *
# # # # # * * * * * * * * * * * * * * * *
# # # # # * * * * * * * * * * * * * * * *
# # # # * * * * * * * * * * * * * * * * #
# # # # * * * * * * * * * * * * * * * * #
# # # * * * # * * * * * * * * * * * * # #
# # * * * # # # * * * * * * * * * * # # #
* * * # # # # # # # * * * * * * # # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
""",
        "Flower": """# # # # # # # * * * * * * * # # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # * * # * * * * * * * * * * * # * * # #
# * * * * # * * * * * * * * * # * * * * #
# * * * * * # * * * # * * * # * * * * * #
* * * * * * * # * * # * * # * * * * * * *
* * * * * * * * # * # * # * * * * * * * *
* * * * * * * * * # # # * * * * * * * * *
* * * * * * # # # # # # # # # * * * * * *
* * * * * * * * * # # # * * * * * * * * *
* * * * * * * * # * # * # * * * * * * * *
* * * * * * * # * * # * * # * * * * * * *
# * * * * * # * * * # * * * # * * * * * #
# * * * * # * * * * * * * * * # * * * * #
# # * * # * * * * * * * * * * * # * * # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # # * * * * * * * # # # # # # #
""",
        "Heart": """# # # * * * * * # # # # # * * * * * # # #
# # * * * * * * * # # # * * * * * * * # #
# * * * * * * * * * # * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
""",
        "Hexagon": """# # # # # # # # # # # # # # # # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # # # # # # # # # # # # # # # #
""",
        "Octagon": """# # # # # # # # # # # # # # # # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # # # # # # # # # # # # # # # # #
""",
        "Pentagon": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
""",
        "Spade": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * # * * * # * * * * * # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
""",
        "Star5": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # * * * * * * * * * * * * * # # # #
* * * * * * * * * * * * * * * * * * * * *
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * # * * * * * * # # # #
# # # # * * * * # # # # # * * * * # # # #
# # # # * * # # # # # # # # # * * # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
""",
        "Star6": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# * * * * * * * * * * * * * * * * * * * #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
""",
        "Star8": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # * * # # # # * * * # # # # * * # # #
# # # * * * * # * * * * * # * * * * # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # * * * * * * * * * * * * * * * * * # #
* * * * * * * * * * * * * * * * * * * * *
# # * * * * * * * * * * * * * * * * * # #
# # # # * * * * * * * * * * * * * # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * # * * * * * # * * * * # # #
# # # * * # # # # * * * # # # # * * # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # # * # # # # # # # # # #
""",
        "Tree": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
""",
        "Triangle": """# # # # # # # # # # * # # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # # * * * # # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # # * * * * * # # # # # # # #
# # # # # # # * * * * * * * # # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # # * * * * * * * * * # # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # # * * * * * * * * * * * # # # # #
# # # # * * * * * * * * * * * * * # # # #
# # # * * * * * * * * * * * * * * * # # #
# # # * * * * * * * * * * * * * * * # # #
# # * * * * * * * * * * * * * * * * * # #
# # * * * * * * * * * * * * * * * * * # #
# * * * * * * * * * * * * * * * * * * * #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
# # # # # # # # # # # # # # # # # # # # #
""",
    }
