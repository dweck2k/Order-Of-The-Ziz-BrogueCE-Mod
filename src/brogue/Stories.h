/*
 *  Stories.h
 *  Cult of the Ziz
 *
 *  Story system for level-based narrative fragments.
 *  Stories are randomized based on the current dungeon depth.
 */

#ifndef Stories_h
#define Stories_h

// Story depth ranges
#define STORY_DEPTH_SHALLOW_MIN     1
#define STORY_DEPTH_SHALLOW_MAX     8
#define STORY_DEPTH_MIDDLE_MIN      9
#define STORY_DEPTH_MIDDLE_MAX      17
#define STORY_DEPTH_DEEP_MIN        18
#define STORY_DEPTH_DEEP_MAX        25
#define STORY_DEPTH_ABYSS_MIN       26
#define STORY_DEPTH_ABYSS_MAX       40

// Number of story variants per depth range
#define STORIES_PER_RANGE           6

// Story structure
typedef struct storyFragment {
    const char *message;
    short minDepth;
    short maxDepth;
} storyFragment;

// Function declarations
void displayLevelStory(short depthLevel);
const char* getRandomStoryForDepth(short depthLevel);

#endif /* Stories_h */
