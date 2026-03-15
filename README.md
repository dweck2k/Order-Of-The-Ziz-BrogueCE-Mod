# Order of the Ziz — מסדר הזיז

> *The lair (מאורה) stretches downward, deeper than any map has charted.*
> *The impure creatures (שיקוצים) have held the Sefer HaShikotz for too long.*
> *The Order has waited since the destruction of the Second Temple.*
> *It is time to descend.*

**Order of the Ziz** is a Jewish apocalyptic roguelike — a mod of [BrogueCE](https://github.com/tmewett/BrogueCE) set in a world of Jewish mysticism and hidden war. You are an initiate of the מסדר דתי-מיסטי, a secret order of scholars and fighters who have guarded the boundaries between the pure and the impure since the fall of the Second Temple. Beneath the earth, in the lightless warrens of the שיקוצים (impure creatures), lies the Sefer HaShikotz — ספר השיקוץ — a forbidden text cataloguing the dark plans of the forces of tumah (טומאה, ritual impurity). You must reach the heart of the lair and retrieve it.

You will not find an Amulet of Yendor here. You will find the **Book of the Abomination** — or you will be consumed trying.

**GitHub:** https://github.com/dweck2k/Order-Of-The-Ziz-BrogueCE-Mod

---

## Screenshots

![Title screen](bin/Screenshot.png)

![Gameplay](bin/Screenshot&#32;(2).png)

*(More screenshots in the `bin/` directory.)*

---

## Download

Windows builds are available at the associated website:

**https://codex-of-margins.com** — *הקודקס של השוליים* (The Codex of the Margins)

Download the latest release, extract it, and run `OrderOfTheZiz.exe`.

---

## Lore — The Order of the Ziz

After the destruction of the Second Temple, certain sages understood that the catastrophe was not merely political. Forces of impurity — the שיקוצים — had pressed their advantage in the moment of Israel's grief. A small circle of kabbalists, warriors, and scribes formed in secret: the **Order of the Ziz** (מסדר הזיז), named for the great mythological bird that guards the boundary between the earthly and the divine.

For centuries the Order has fought quietly, tracing networks of underground lairs where the שיקוצים breed and organize. Their scholars have documented these creatures — their hierarchies, their weaknesses, the seals that bind them. And they have hunted, always, for the **Sefer HaShikotz** (ספר השיקוץ): the master text of the dark forces, a grimoire describing plans that span generations.

You have trained for years. You have been given one segula (סגולה, a protective charm) and sent downward alone. The Order does not send armies. It sends one person, prepared, into the dark.

### What You Will Find

The dungeon of BrogueCE has been re-dressed for this world:

| Original Term | In-Game Term | Hebrew Meaning |
|---|---|---|
| Dungeons of Doom | Burrows of the Abomination | מאורות השיקוץ |
| Amulet of Yendor | Book of the Abomination | ספר השיקוץ |
| Potions | Segulaot | סגולות — protective charms |
| Scrolls | Piyutim | פיוטים — liturgical poems |
| Wands | Staffs | — |
| Rings | Signets | — |

The title screen displays a seven-branched Menorah wreathed in flame. The opening of each run is accompanied by a lore passage situating you in the Order's mission.

---

## Playing

### Windows

Download the release from [codex-of-margins.com](https://codex-of-margins.com) and run `OrderOfTheZiz.exe`.

If you built from source, run `bin/OrderOfTheZiz.exe` (or `cd bin && ./OrderOfTheZiz.exe` from a shell).

Press `G` to toggle graphical tiles. Run `OrderOfTheZiz --help` (or `OrderOfTheZiz-cmd.bat` from a Windows command prompt) for command-line options.

### Linux

Run the `./brogue` script from the project root.

Requires SDL2 and SDL2_image from your package manager:

- Debian/Ubuntu: `libsdl2-2.0-0 libsdl2-image-2.0-0`
- Fedora: `SDL2 SDL2_image`
- Arch: `sdl2 sdl2_image`

You can also run `./make-link-for-desktop.sh` to generate a `.desktop` launcher.

---

## Building from Source

Full build instructions are in [`BUILD.md`](BUILD.md). A summary follows.

### Requirements

- GCC or Clang
- Make
- diffutils (`cmp`)
- SDL2 and SDL2_image (for graphical builds)

### Windows (MSYS2)

1. Install [MSYS2](https://www.msys2.org/) for x86_64.

2. In the MSYS2 shell, install dependencies:

    ```
    pacman -S make diffutils mingw-w64-x86_64-{gcc,SDL2,SDL2_image}
    ```

3. Open the **Mingw64** shell, navigate to the project directory, and run:

    ```
    make SYSTEM=WINDOWS GRAPHICS=YES bin/brogue.exe
    ```

    The output binary and required DLLs will be in `bin/`.

    > Note: `windres` fails when invoked from Git Bash. Use the MSYS2 bash at
    > `C:/msys64/usr/bin/bash.exe` if needed.
    >
    > If the build fails with a permission error on `brogue.exe`, kill any running
    > instance first: `taskkill /F /IM brogue.exe` (or `OrderOfTheZiz.exe` if renamed)

### Mac

1. Install [Homebrew](https://brew.sh/) and SDL2:

    ```
    brew install sdl2 sdl2_image
    ```

2. Build:

    ```
    make bin/brogue
    ```

### Linux

1. Install dependencies (Debian/Ubuntu):

    ```
    sudo apt install make gcc diffutils libsdl2-2.0-0 libsdl2-dev libsdl2-image-2.0-0 libsdl2-image-dev
    ```

2. Build:

    ```
    make bin/brogue
    ```

---

## The Universe — Codex of the Margins

The Order of the Ziz game is part of a larger fictional universe developed at
**[codex-of-margins.com](https://codex-of-margins.com)** — *הקודקס של השוליים*.

The Codex of the Margins publishes the lore of this world across multiple forms:
comics, short stories, and the game itself. The same Order, the same creatures,
the same long war — refracted through different genres and formats.

---

## Based On

This mod is built on **[BrogueCE](https://github.com/tmewett/BrogueCE)** — the
Community Edition continuation of Brian Walker's *Brogue*, one of the most
acclaimed traditional roguelikes.

- [BrogueCE Wiki](https://brogue.fandom.com/wiki/Brogue_Wiki)
- [Brogue subreddit](https://www.reddit.com/r/brogueforum/)

---

## License

The BrogueCE base is licensed under the [GNU Affero General Public License v3.0](LICENSE.txt).
Mod content (lore text, title art, thematic changes) is copyright the Order of the Ziz project authors.
