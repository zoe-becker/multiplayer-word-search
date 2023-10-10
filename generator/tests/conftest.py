import pytest

from word_search_generator import WordSearch
from word_search_generator.mask import shapes


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
