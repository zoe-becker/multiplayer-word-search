import csv
import json
import os
import random
import re
import uuid
from pathlib import Path

import pdfplumber
import pytest
from pypdf import PdfReader

from word_search_generator import WordSearch, config, utils
from word_search_generator.game import EmptyPuzzleError
from word_search_generator.word import Direction, Word


def check_chars(puzzle, word):
    row, col = word.position
    for c in word.text:
        if c != puzzle[row][col]:
            return False
        row += word.direction.r_move
        col += word.direction.c_move
    return True


def test_export_csv(words, tmp_path: Path):
    puzzle = WordSearch(words)
    path = Path.joinpath(tmp_path, "test.csv")
    puzzle.save(path, format="csv")
    with open(path) as f:
        data = f.read()
    assert not re.findall("\nSOLUTION\n", data)


def test_export_json(words, tmp_path: Path):
    puzzle = WordSearch(words)
    path = Path.joinpath(tmp_path, "test.json")
    final_path = puzzle.save(path, format="json")
    data = json.loads(Path(final_path).read_text())
    for word in puzzle.words:
        assert word.text in data["words"]


@pytest.mark.parametrize(
    "format",
    [
        ("csv",),
        ("json",),
        ("pdf",),
    ],
)
def test_export_empty_puzzle(tmp_path: Path, format):
    puzzle = WordSearch()
    path = Path.joinpath(tmp_path, f"test.{format}")
    with pytest.raises(EmptyPuzzleError):
        puzzle.save(path, format=format)


def test_export_pdf_puzzles(iterations, tmp_path: Path):
    """Export a bunch of puzzles as PDF and make sure they are all 1-page."""
    puzzles = []
    pages = set()
    for _ in range(iterations):
        size = random.choice(range(config.min_puzzle_size, config.max_puzzle_size))
        words = ",".join(
            utils.get_random_words(
                random.randint(config.min_puzzle_words, config.max_puzzle_words)
            )
        )
        level = random.randint(1, 3)
        puzzle = WordSearch(words, level=level, size=size)
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        puzzle.save(path, format="pdf")
        puzzles.append(path)
    for p in puzzles:
        with open(p, "rb") as f:
            pdf = PdfReader(f)
            pages.add(len(pdf.pages))
    assert pages == {1}


def test_export_pdf_puzzle_with_solution(iterations, tmp_path: Path):
    """Make sure a pdf puzzle exported with the solution is 2 pages."""
    puzzles = []
    pages = set()
    for _ in range(iterations):
        size = random.choice(range(config.min_puzzle_size, config.max_puzzle_size))
        words = ",".join(
            utils.get_random_words(
                random.randint(config.min_puzzle_words, config.max_puzzle_words)
            )
        )
        level = random.randint(1, 3)
        puzzle = WordSearch(words, level=level, size=size)
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        puzzle.save(path, solution=True)
        puzzles.append(path)
    for p in puzzles:
        with open(p, "rb") as f:
            pdf = PdfReader(f)
            pages.add(len(pdf.pages))
    assert pages == {2}


def test_export_pdf_overwrite_file_error(tmp_path: Path):
    """Try to export a puzzle with the name of a file that is already present."""
    path = Path.joinpath(tmp_path, "test_pdf.pdf")
    path.touch()
    puzzle = WordSearch("cat, bird, donkey")
    with pytest.raises(FileExistsError):
        puzzle.save(path)


def test_export_csv_overwrite_file_error(tmp_path: Path):
    """Try to export a puzzle with the name of a file that is already present."""
    path = Path.joinpath(tmp_path, "test_csv.pdf")
    path.touch()
    puzzle = WordSearch("cat, bird, donkey")
    with pytest.raises(FileExistsError):
        puzzle.save(path, format="CSV")


def test_export_json_overwrite_file_error(tmp_path: Path):
    """Try to export a puzzle with the name of a file that is already present."""
    path = Path.joinpath(tmp_path, "test_json.pdf")
    path.touch()
    puzzle = WordSearch("cat, bird, donkey")
    with pytest.raises(FileExistsError):
        puzzle.save(path, format="JSON")


@pytest.mark.skipif(os.name == "nt", reason="need to figure out")
def test_export_pdf_os_error(words):
    """Try to export a puzzle to a place you don't have access to."""
    puzzle = WordSearch(words)
    with pytest.raises(OSError):
        puzzle.save("/test.pdf")


@pytest.mark.skipif(os.name == "nt", reason="need to figure out")
def test_export_csv_os_error(words):
    """Try to export a puzzle to a place you don't have access to."""
    puzzle = WordSearch(words)
    with pytest.raises(OSError):
        puzzle.save("/test.csv")


def test_pdf_output_key(iterations, tmp_path: Path):
    def parse_puzzle(extraction):
        puzzle = []
        for line in extraction.split("\n"):
            if line.startswith("WORD SEARCH"):
                continue
            elif line.startswith("Find words going"):
                break
            else:
                puzzle.append(list(line))
        return puzzle

    def parse_words(extraction):
        words = set()
        for w in extraction.replace("\n", " ").split(": ")[1].split("), "):
            data = w.replace("(", "").replace(")", "").replace(",", "").split()
            text = data[0][1:] if "*" in data[0] else data[0]
            secret = bool("*" in data[0])
            word = Word(text, secret=secret)
            word.direction = Direction[data[1]]
            word.start_row = int(data[4]) - 1
            word.start_column = int(data[3]) - 1
            words.add(word)
        return words

    results = []
    for _ in range(iterations):
        ws = WordSearch(size=random.randint(8, 21))
        ws.random_words(random.randint(5, 21))
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        ws.save(path)
        reader = PdfReader(path)
        page = reader.pages[0]
        puzzle = parse_puzzle(page.extract_text(0))
        words = parse_words(page.extract_text(180))
        results.append(all(check_chars(puzzle, word) for word in words))  # type: ignore

    assert all(results)


def test_pdf_output_words(iterations, tmp_path: Path):
    def parse_word_list(extraction):
        return {
            word.strip()
            for word in "".join(
                extraction.split("Find words ")[1].split("\n")[1:]
            ).split(",")
        }

    def parse_words(extraction):
        words = set()
        for w in extraction.replace("\n", " ").split(": ")[1].split("), "):
            data = w.replace("(", "").replace(")", "").replace(",", "").split()
            text = data[0][1:] if "*" in data[0] else data[0]
            secret = bool("*" in data[0])
            word = Word(text, secret=secret)
            word.direction = Direction[data[1]]
            word.start_row = int(data[4]) - 1
            word.start_column = int(data[3]) - 1
            words.add(word)
        return words

    results = []
    for i in range(iterations):
        ws = WordSearch(size=random.randint(8, 21))
        ws.random_words(random.randint(5, 21))
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        ws.save(path)
        reader = PdfReader(path)
        page = reader.pages[0]
        word_list = parse_word_list(page.extract_text(0))
        words = parse_words(page.extract_text(180))
        for word in words:
            if word.secret:
                results.append(word.text not in word_list)
            else:
                results.append(word.text in word_list)

    assert all(results)


def test_pdf_output_puzzle_size(iterations, tmp_path: Path):
    def parse_puzzle(extraction):
        puzzle = []
        for line in extraction.split("\n"):
            if line.startswith("WORD SEARCH"):
                continue
            elif line.startswith("Find words going"):
                break
            else:
                puzzle.append(list(line))
        return puzzle

    results = []
    for _ in range(iterations):
        ws = WordSearch(size=random.randint(8, 21))
        ws.random_words(random.randint(5, 21))
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        ws.save(path)
        reader = PdfReader(path)
        page = reader.pages[0]
        puzzle = parse_puzzle(page.extract_text(0))
        results.append(
            ws.size == len(puzzle) and ws.size == len(puzzle[0])
        )  # type: ignore

    assert all(results)


def test_pdf_output_solution_characters(iterations, tmp_path: Path):
    results = []
    for _ in range(iterations):
        ws = WordSearch(size=random.randint(8, 21))
        ws.random_words(random.randint(5, 21))
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        ws.save(path=path, format="PDF", solution=True)
        with pdfplumber.open(path) as pdf:
            chars = pdf.pages[1].chars  # get all characters from page 2
        word_chars = sorted({c for word in ws.placed_words for c in word.text})
        highlighted_chars = sorted(
            {
                char["text"]
                for char in chars
                if char["non_stroking_color"] == (1.0, 0.0, 0.0)
            }
        )
        results.append(word_chars == highlighted_chars)

    assert all(results)


def test_pdf_output_solution_character_placement(iterations, tmp_path: Path):
    def check_chars(puzzle, word):
        row, col = word.position
        for c in word.text:
            if c != puzzle[row][col]["text"] or puzzle[row][col][
                "non_stroking_color"
            ] != (1.0, 0.0, 0.0):
                return False
            row += word.direction.r_move
            col += word.direction.c_move
        return True

    results = []
    for _ in range(iterations):
        ws = WordSearch(size=random.randint(8, 21))
        ws.random_words(random.randint(5, 21))
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        ws.save(path=path, format="PDF", solution=True)
        with pdfplumber.open(path) as pdf:
            chars = pdf.pages[1].chars  # get all characters from page 2
        known_title = "WORD SEARCH (SOLUTION)"
        puzzle_chars = chars[len(known_title) : len(known_title) + ws.size**2]
        puzzle = [
            puzzle_chars[i * ws.size : i * ws.size + ws.size] for i in range(ws.size)
        ]
        results.append(all(check_chars(puzzle, word) for word in ws.placed_words))

    assert all(results)


@pytest.mark.skipif(os.name == "nt", reason="need to figure out")
def test_csv_output_puzzle_size(iterations, tmp_path: Path):
    def parse_puzzle(fp):
        puzzle = []
        with open(fp, newline="") as f:
            data = csv.reader(f)
            for i, row in enumerate(data):
                if i == 0:
                    continue
                elif row == [""]:
                    break
                else:
                    puzzle.append(row)
        return puzzle

    results = []
    for _ in range(iterations):
        ws = WordSearch(size=random.randint(8, 21))
        ws.random_words(random.randint(5, 21))
        path = Path.joinpath(tmp_path, f"{uuid.uuid4()}.pdf")
        ws.save(path, format="CSV")
        puzzle = parse_puzzle(path)
        results.append(
            ws.size == len(puzzle) and ws.size == len(puzzle[0])
        )  # type: ignore

    assert all(results)
