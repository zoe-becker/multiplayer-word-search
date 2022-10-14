import argparse
import pathlib
import sys
from typing import Sequence

from word_search_generator import WordSearch, __app_name__, __version__, config, utils


class RandomAction(argparse.Action):
    """Restrict argparse `-r`, `--random` inputs."""

    def __call__(self, parser, namespace, values, option_string=None):
        min_val = config.min_puzzle_words
        max_val = config.max_puzzle_words
        if values < min_val or values > max_val:
            parser.error(f"{option_string} must be >={min_val} and <={max_val}")
        setattr(namespace, self.dest, values)


class DifficultyAction(argparse.Action):
    """Validate difficulty level integers or directional strings."""

    def __call__(self, parser, namespace, values, option_string=None):
        if values.isnumeric():
            setattr(namespace, self.dest, int(values))
        else:
            for d in values.split(","):
                if d.strip().isnumeric():
                    parser.error(
                        f"{option_string} must be \
either numeric levels \
({', '.join([str(i) for i in config.level_dirs.keys()])}) or accepted \
cardinal directions ({', '.join([d.name for d in config.Direction])})."
                    )
            setattr(namespace, self.dest, values)


class SizeAction(argparse.Action):
    """Restrict argparse `-s`, `--size` inputs."""

    def __call__(self, parser, namespace, values, option_string=None):
        min_val = config.min_puzzle_size
        max_val = config.max_puzzle_size
        if values < min_val or values > max_val:
            parser.error(f"{option_string} must be >={min_val} and <={max_val}")
        setattr(namespace, self.dest, values)


def main(argv: Sequence[str] | None = None) -> int:
    """Word Search Generator CLI.

    Args:
        argv (Sequence[str] | None, optional): Command line arguments. Defaults to None.

    Returns:
        int: Exit status.
    """
    parser = argparse.ArgumentParser(
        description=f"""Generate Word Search Puzzles! \


Valid Levels: {', '.join([str(i) for i in config.level_dirs.keys()])}
Valid Directions: {', '.join([d.name for d in config.Direction])}
Directions are to be provided as a comma-separated list.""",
        epilog="Copyright 2022 Josh Duncan (joshbduncan.com)",
        prog=__app_name__,
        formatter_class=argparse.RawDescriptionHelpFormatter,
    )
    group = parser.add_mutually_exclusive_group()
    group.add_argument(
        "words",
        type=str,
        nargs="*",
        default=sys.stdin,
        help="Words to include in the puzzle (default: stdin).",
    )
    group.add_argument(
        "-r",
        "--random",
        type=int,
        action=RandomAction,
        help="Generate {n} random words to include in the puzzle.",
    )
    parser.add_argument(
        "-x",
        "--secret-words",
        type=str,
        default="",
        help="Secret bonus words not included in the word list.",
    )
    # new implementation of -l, --level allowing for more flexibility
    # keeping -l, --level for backwards compatibility
    parser.add_argument(
        "-d",
        "--difficulty",
        "-l",
        "--level",
        action=DifficultyAction,
        help="Difficulty level (numeric) or cardinal directions \
            puzzle words can go. See valid arguments above.",
    )
    parser.add_argument(
        "-xd",
        "--secret-difficulty",
        action=DifficultyAction,
        help="Difficulty level (numeric) or cardinal directions \
            secret puzzle words can go. See valid arguments above.",
    )
    parser.add_argument(
        "-s",
        "--size",
        action=SizeAction,
        type=int,
        help=f"Puzzle size >={config.min_puzzle_size} and <={config.max_puzzle_size}",
    )
    parser.add_argument(
        "-c",
        "--cheat",
        action="store_true",
        help="Show the puzzle solution or include it within the `-o, --output` file.",
    )
    parser.add_argument(
        "-o",
        "--output",
        type=pathlib.Path,
        help="Output path for saved puzzle. Specify export type by appending "
        "'.pdf' or '.csv' to your path (default: PDF).",
    )
    parser.add_argument(
        "--version", action="version", version=f"%(prog)s {__version__}"
    )
    args = parser.parse_args(argv)

    # process puzzle words
    words = ""
    if args.random:
        words = utils.get_random_words(args.random)
    else:
        if isinstance(args.words, list):
            words = ",".join(args.words)
        elif not sys.stdin.isatty():
            # disable interactive tty which can be confusing
            # but still process words were piped in from the shell
            words = args.words.read().rstrip()

    # if not words were found exit the script
    if not words and not args.secret_words:
        print("No words provided. Learn more with the '-h' flag.", file=sys.stderr)
        return 1

    # create a new puzzle object from provided arguments
    puzzle = WordSearch(
        words,
        level=args.difficulty,
        size=args.size,
        secret_words=args.secret_words,
        secret_level=args.secret_difficulty,
    )

    # show the result
    if args.output:
        foutput = puzzle.save(path=args.output, solution=args.cheat)
        print(f"Puzzle saved: {foutput}")
    else:
        puzzle.show(solution=args.cheat)

    return 0


if __name__ == "__main__":
    sys.exit(main())
