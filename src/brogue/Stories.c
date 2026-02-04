/*
 *  Stories.c
 *  Cult of the Ziz
 *
 *  Story system for level-based narrative fragments based on Jewish mythology.
 *  The Ziz is the primordial giant bird, alongside Leviathan (sea) and Behemoth (land).
 *  Stories are randomized based on the current dungeon depth and game seed.
 */

#include "Rogue.h"
#include "Stories.h"

// Shallow depths (1-8): Introduction to the cult, ancient writings
static const storyFragment shallowStories[] = {
    {"Ancient Hebrew script adorns the walls: 'The Ziz spreads its wings and darkens the sun.'", 1, 8},
    {"You find torn parchment: 'When the Ziz cries out, the eagles fear...'", 1, 8},
    {"Carved into stone: 'Three primordial beasts were created - Behemoth, Leviathan, and Ziz.'", 1, 8},
    {"A faded scroll reads: 'The cult guards the Seal, waiting for the end of days.'", 1, 8},
    {"Etched symbols depict a massive bird whose wingspan reaches from horizon to horizon.", 1, 8},
    {"You hear distant chanting in an ancient tongue, echoing through forgotten halls.", 1, 8},
};

// Middle depths (9-17): Deeper cult lore, rituals
static const storyFragment middleStories[] = {
    {"The walls are covered in feathers of impossible size, each one taller than a man.", 9, 17},
    {"An altar bears inscription: 'The flesh of the Ziz shall be served at the great feast.'", 9, 17},
    {"Ancient texts speak of the Ziz protecting Israel by shading them with its wings.", 9, 17},
    {"You discover a ritual chamber - circles drawn in ash, surrounded by enormous talons.", 9, 17},
    {"A mural depicts the Ziz standing with one foot in the sea, head reaching the heavens.", 9, 17},
    {"Cultist bones surround a pedestal - they died waiting for a sign that never came.", 9, 17},
};

// Deep depths (18-25): Approaching the divine
static const storyFragment deepStories[] = {
    {"The air itself trembles with divine presence. Something ancient slumbers nearby.", 18, 25},
    {"You feel the weight of millennia pressing down - this place predates humanity.", 18, 25},
    {"A voice echoes in your mind: 'The righteous shall feast upon Leviathan, Behemoth, and Ziz.'", 18, 25},
    {"The shadows here move with purpose, as if the darkness itself is alive and watching.", 18, 25},
    {"Massive feathers embedded in stone radiate an otherworldly warmth.", 18, 25},
    {"The prophecy carved here speaks of three great beasts saved for the world to come.", 18, 25},
};

// Abyss depths (26-40): Near the Seal
static const storyFragment abyssStories[] = {
    {"Reality bends around the Seal's presence - you are close to something beyond mortal ken.", 26, 40},
    {"The Ziz's essence permeates everything here. Even the stones seem to breathe.", 26, 40},
    {"Ancient guardians stir, bound by oath to protect the Seal until the appointed time.", 26, 40},
    {"You stand at the threshold between worlds - the Seal awaits its destined bearer.", 26, 40},
    {"The cult's ultimate secret lies before you: a fragment of divine creation itself.", 26, 40},
    {"Whispers of the tzaddikim fill the air - the righteous dead who await the final feast.", 26, 40},
};

// Get the story array and count for a given depth
static void getStoriesForDepth(short depthLevel, const storyFragment **stories, int *count) {
    if (depthLevel >= STORY_DEPTH_ABYSS_MIN) {
        *stories = abyssStories;
        *count = sizeof(abyssStories) / sizeof(storyFragment);
    } else if (depthLevel >= STORY_DEPTH_DEEP_MIN) {
        *stories = deepStories;
        *count = sizeof(deepStories) / sizeof(storyFragment);
    } else if (depthLevel >= STORY_DEPTH_MIDDLE_MIN) {
        *stories = middleStories;
        *count = sizeof(middleStories) / sizeof(storyFragment);
    } else {
        *stories = shallowStories;
        *count = sizeof(shallowStories) / sizeof(storyFragment);
    }
}

// Get a random story appropriate for the current depth
const char* getRandomStoryForDepth(short depthLevel) {
    const storyFragment *stories;
    int count;

    getStoriesForDepth(depthLevel, &stories, &count);

    // Use depth and a random value to select story variant
    // This ensures different stories on different depths while remaining deterministic with seed
    int index = (depthLevel + rand_range(0, count - 1)) % count;

    return stories[index].message;
}

// Display a story message for the current level
void displayLevelStory(short depthLevel) {
    // Only show stories on certain levels to avoid spam
    // Show on every 3rd level plus the first level
    if (depthLevel == 1 || depthLevel % 3 == 0) {
        const char *story = getRandomStoryForDepth(depthLevel);
        if (story != NULL) {
            flavorMessage(story);
        }
    }
}
