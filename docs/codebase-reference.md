# Games Hub Codebase Reference

## Overview

This project is a Laravel 12 web app for a games hub with a public Blade-based frontend, a Filament admin panel, and a Lighthouse GraphQL API.

The current implementation centers around a unified content model:

- `games` defines each playable game mode.
- `challenges` stores the actual playable prompts/questions.
- `genres` groups challenges and games by topic.
- `game_items` powers autocomplete/search datasets such as players, clubs, stadiums, actors, and movies.
- `challenge_hints` stores ordered hints for a challenge.

## Stack

- PHP `^8.2`
- Laravel `^12.0`
- Filament `^3.0` for admin
- Lighthouse GraphQL `^6.66`
- Spatie Media Library `^11.0`
- Blade views with inline CSS/JS for the public UI
- SQLite is supported by default via `database/database.sqlite`

## Main Entry Points

### Web routes

Defined in `routes/web.php`.

- `/` -> `HomeController@index`
- `/games` -> `HomeController@games`
- `/games/{slug}/{challenge?}` -> `GamePlayController@play`
- `/challenges/{challenge}/check` -> answer checking
- `/challenges/{challenge}/hint` -> next hint
- `/challenges/{challenge}/reveal` -> reveal answer
- `/search/{type}` -> autocomplete search endpoint
- `/about`, `/contact`, `/privacy`, `/terms`, `/disclaimer`

### Admin

Configured in `app/Providers/Filament/AdminPanelProvider.php`.

- Admin path: `/admin`
- Uses Filament built-in login flow
- Discovers resources from `app/Filament/Resources`

### GraphQL

- Schema: `graphql/schema.graphql`
- Resolver classes:
  - `app/GraphQL/Queries/GameQueries.php`
  - `app/GraphQL/Queries/GameItemQueries.php`
  - `app/GraphQL/Mutations/GameMutations.php`

GraphQL overlaps with the web app by exposing games, challenges, genres, search, answer checking, hints, and reveal actions.

## Core Domain Model

### `Genre`

File: `app/Models/Genre.php`

- Fields: English/Arabic names, `slug`, `icon`, `sort_order`, `is_active`
- Relations:
  - has many `challenges`
  - has many `games`

### `Game`

File: `app/Models/Game.php`

- Represents a game mode such as `guess-silhouette`, `anagram-arena`, or `transfer-chain`
- Important fields:
  - `title`
  - `slug`
  - `description`
  - `game_type`
  - `answer_type`
  - `is_active`
- Relations:
  - belongs to `genre`
  - has many `challenges`
- Media:
  - cover image via Spatie media collection `cover`
  - `image_url` falls back to stored `image` path if no media exists

### `Challenge`

File: `app/Models/Challenge.php`

- Stores individual playable units for a game
- Important fields:
  - `game_id`
  - `genre_id`
  - `difficulty`
  - `stimulus_type`
  - `stimulus_data` JSON
  - `answer`
  - `answers` JSON for multi-answer cases
  - `answer_type`
  - `autocomplete_type`
  - `is_active`
- Relations:
  - belongs to `game`
  - belongs to `genre`
  - has many `hints`

`stimulus_data` is the flexible payload that lets the app render different challenge formats without needing separate tables. The model exposes helper accessors like `image_path`, `youtube_url`, `question`, `scrambled_word`, `part_a`, `part_b`, `club_a`, and `club_b`.

### `ChallengeHint`

- Backed by `challenge_hints`
- Ordered by `sort_order`
- Used by both the web and GraphQL hint flows

### `GameItem`

File: `app/Models/GameItem.php`

- Shared lookup dataset for autocomplete/search
- Types include `player`, `club`, `stadium`, `actor`, `movie`, and others in admin
- Fields:
  - `type`
  - `name_en`
  - `name_ar`
  - `country`
  - `external_id`
  - `metadata` JSON
  - `is_active`

## Public App Flow

### Home and game listing

Files:

- `app/Http/Controllers/HomeController.php`
- `resources/views/home.blade.php`
- `resources/views/games/index.blade.php`

The home and games pages only surface games where:

- `is_active = true`
- the game has at least one related challenge

### Unified play page

Primary controller: `app/Http/Controllers/GamePlayController.php`

Primary view: `resources/views/games/play_unified.blade.php`

How it works:

1. Resolve the game by slug.
2. Optionally filter challenges by `genre` query string.
3. Optionally jump to a challenge via `level` query string.
4. Otherwise load the newest active challenge.
5. Render the page using dynamic Blade components based on challenge data.

Stimulus rendering components:

- `resources/views/components/games/stimulus/image.blade.php`
- `resources/views/components/games/stimulus/video.blade.php`
- `resources/views/components/games/stimulus/text.blade.php`
- `resources/views/components/games/stimulus/scrambled.blade.php`
- `resources/views/components/games/stimulus/sequence.blade.php`

Interaction components:

- `resources/views/components/games/interaction/standard.blade.php`
- `resources/views/components/games/interaction/group.blade.php`

The app special-cases `group-players` in the interaction layer, while most other games use the standard answer form.

### Answer, hint, and reveal flow

Handled by `GamePlayController`.

- `checkAnswer()`:
  - exact string match for most web requests
  - custom group logic for `group-players`
- `getHint()`:
  - returns the next unseen hint
- `revealAnswer()`:
  - returns a single answer or answer array
- `search()`:
  - queries `game_items` by `type` and partial `name_en`

Important note: the web controller currently uses stricter answer matching than GraphQL. GraphQL uses similarity checks via Levenshtein distance, but the web route mostly uses exact lowercase-trimmed equality.

## Game Types in Seed Data

Seeded in `database/seeders/GameSeeder.php`.

Current seeded games include:

- Guess the Silhouette
- Anagram Arena
- Transfer Chain
- Stadium Spotter
- Vowel Void
- Kit Detective
- Black & White
- Highlight Moments
- Trophy Hunter
- Football Glossary
- Missing Link
- Career Path
- Group Guess

These use abstract `game_type` values such as:

- `image_guess`
- `word_puzzle`
- `connection_guess`

In practice, the frontend now relies more on `challenge.stimulus_type` plus game slug-specific behavior than on `game_type` alone.

## Database Shape

Key migrations live in `database/migrations/`.

- `create_genres_table`
- `create_games_table`
- `create_challenges_table`
- `create_challenge_hints_table`
- `create_media_table`
- `create_game_items_table`
- `add_autocomplete_type_to_challenges_table`

Notable schema decisions:

- `challenges.stimulus_data` is JSON and carries format-specific fields.
- `challenges.answers` supports multiple valid answers.
- `game_items` has a compound index on `type` + `name_en` for autocomplete.
- media is stored through Spatie's polymorphic `media` table.

## Seeders and Data Sources

Main seeder chain: `database/seeders/DatabaseSeeder.php`

- `UserSeeder`
- `GenreSeeder`
- `GameSeeder`
- `GameItemSeeder`
- `AnagramSeeder`

Data sources found in the repo:

- `database/seeders/game_items_dump.sql`
- `data/*.csv`

Observations:

- `GameItemSeeder` imports raw SQL from `game_items_dump.sql`.
- `AnagramSeeder` creates challenge rows and also syncs missing `game_items` so autocomplete works.
- The repository contains broader CSV data files that look like source/import material, but the current default seeder path is mostly focused on games, items, and anagram challenges.

## Frontend Notes

### Layout

Base layout: `resources/views/layouts/app.blade.php`

- inline design system and shared styles
- top navigation and footer
- shared stats bar via `<x-game-stats />`
- shared bookmark and autocomplete script includes
- hint modal shell in the layout

### Answer form and autocomplete

Key file: `resources/views/components/player-answer-form.blade.php`

- answer input stores its autocomplete type in `data-answer-type`
- play page JS wires this to `/search/{type}`

### Bookmarks and client state

Key file: `public/js/bookmarks.js`

- bookmarks are stored in a `bookmarked_games` cookie
- game progress stats use a separate `game_stats` cookie

## Stats and Shared View State

Files:

- `app/Traits/TracksGameStats.php`
- `app/Providers/AppServiceProvider.php`

What exists:

- a cookie-backed stats structure with streak, last played date, totals, and played challenge list
- a global view composer that injects `global_stats` into all views

Important note: the `TracksGameStats` trait defines `getStats()` and `updateStats()`, but the current controller flow does not appear to call `updateStats()`. The stats UI exists, but the mutation/update path looks incomplete or unused in the web layer.

## Filament Admin Coverage

Resources under `app/Filament/Resources` provide CRUD for:

- `GameResource`
- `ChallengeResource`
- `GenreResource`
- `GameItemResource`

The most complete admin workflow is `ChallengeResource`, which supports:

- selecting game and genre
- difficulty and stimulus type
- answer and multi-answer entry
- dynamic `stimulus_data` fields based on stimulus type
- nested hint management through a repeater

This resource is effectively the editorial backend for the playable content model.

## GraphQL Notes

GraphQL exposes a second interface for the same domain.

Useful queries:

- `games`
- `genres`
- `challenges(game_id:, genre_id:)`
- `searchPlayers`
- `searchClubs`
- `searchStadiums`
- `searchItems`

Useful mutations:

- `checkAnswer`
- `getHint`
- `revealAnswer`

Observations from the schema:

- `Challenge.answer_type` is declared twice in `graphql/schema.graphql`.
- the mutation fields are duplicated once under a "legacy" comment, even though the definitions are identical.

Those duplicates are strong candidates for cleanup.

## Tests and Maintenance Gaps

### Existing tests

- `tests/Feature/ExampleTest.php`
- `tests/Feature/WordGamesTest.php`

### Current state

`WordGamesTest.php` appears to target an older architecture:

- references models that do not exist in the current app structure, such as `AnagramChallenge` and `TransferChainChallenge`
- references `Category` and `category_id`, while the current schema uses `Genre` and `genre_id`
- references legacy routes like `/anagram/{id}/check` instead of the unified `/challenges/{challenge}/check`

This means the test suite likely does not reflect the current codebase design.

## Suggested Mental Model

When working in this app, think in this order:

1. `Game` describes the mode and route slug.
2. `Challenge` carries the actual content and rendering payload.
3. `stimulus_type` decides which visual component renders.
4. game slug may still trigger special answer logic.
5. `GameItem` supports autocomplete and searchable answer datasets.
6. Filament is the primary content management surface.

## Useful Files to Start With

- `routes/web.php`
- `app/Http/Controllers/GamePlayController.php`
- `app/Models/Game.php`
- `app/Models/Challenge.php`
- `resources/views/games/play_unified.blade.php`
- `resources/views/components/games/interaction/standard.blade.php`
- `resources/views/components/games/interaction/group.blade.php`
- `app/Filament/Resources/ChallengeResource.php`
- `graphql/schema.graphql`
