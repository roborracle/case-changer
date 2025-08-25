# Case Changer Pro - Comprehensive Project Brief
**Date:** 2025-08-17
**Status:** FEATURE EXPANSION IN PROGRESS

## Project Vision
Create the most comprehensive, professional text transformation tool that surpasses all existing alternatives, providing real-time text conversion with 50+ case styles, intelligent text processing, smart preservation systems, and complete style guide compliance with educational features.

## Core Features Required

### 1. Basic Case Conversion Tools (ESSENTIAL - 26 Styles)
- **lowercase** - convert everything to lowercase
- **UPPERCASE** - CONVERT EVERYTHING TO UPPERCASE  
- **Title Case** - Capitalize First Letter of Each Word
- **Sentence case** - Capitalize first letter of sentences only
- **camelCase** - firstWordLowerCaseRestCapitalized
- **PascalCase** - EveryWordCapitalizedNoSpaces
- **snake_case** - words_separated_by_underscores
- **CONSTANT_CASE** - UPPER_SNAKE_CASE
- **kebab-case** - words-separated-by-hyphens
- **dot.case** - words.separated.by.dots
- **path/case** - words/separated/by/slashes
- **aLtErNaTiNg CaSe** - EvErY oThEr LeTtEr
- **InVeRsE CaSe** - sWAP cASE OF eACH lETTER
- **Capitalize First Letter** - Only the very first letter
- **Capitalize Words** - First Letter Of Each Word (basic)
- **Reverse Text** - txeT esreveR
- **Randomize Case** - RanDOm cASe foR eAcH LeTTer
- **Remove Whitespace** - Removeallspaces
- **Remove Extra Spaces** - Normalize multiple spaces
- **Slug Case** - words-separated-for-urls
- **Header Case** - Proper HTTP-Header-Case-Format
- **Train-Case** - Every-Word-Capitalized-With-Hyphens
- **Spongebob Case** - sPoNgEbOb MoCkInG cAsE
- **Wide Text** - Ｗｉｄｅ　ｃｈａｒａｃｔｅｒｓ (Unicode)
- **Sentence Case (Preserve Names)** - Keeps proper nouns capitalized

### 2. Style Guide Specific Title Cases (16 Guides)
- **AP Style Title Case** - Associated Press guidelines
- **MLA Style Title Case** - Modern Language Association
- **Chicago Style Title Case** - Chicago Manual of Style
- **APA Style Title Case** - American Psychological Association  
- **Bluebook Legal Citation Style** - Legal citations
- **AMA Style Title Case** - American Medical Association
- **NYT Style Title Case** - New York Times
- **Wikipedia Style Title Case** - Wikipedia conventions
- **IEEE Style Title Case** - Institute of Electrical and Electronics Engineers
- **Harvard Style Title Case** - Harvard referencing
- **Vancouver Style Title Case** - Biomedical journals
- **OSCOLA Legal Style** - Oxford Standard for Citation of Legal Authorities
- **Reuters Style Title Case** - Reuters news agency
- **Bloomberg Style Title Case** - Bloomberg financial
- **Oxford Style Title Case** - Oxford University Press
- **Cambridge Style Title Case** - Cambridge University Press

### 3. Core Text Processing Features

#### Smart Preservation System
- Automatically detect and preserve URLs during conversion
- Automatically detect and preserve email addresses during conversion
- Built-in brand name dictionary (iPhone, eBay, LinkedIn, PayPal, McDonald's, etc.)
- Preserve anything in quotes, backticks, or parentheses (toggleable)
- Custom preservation list stored in localStorage

#### Multi-Level Undo/Redo System
- Store last 20 text states in memory
- Visual timeline showing conversion history
- Click any previous state to restore
- Keyboard shortcuts: Cmd/Ctrl+Z (undo), Cmd/Ctrl+Shift+Z (redo)

#### Partial Text Selection Conversion
- Allow text selection within textarea
- Convert only highlighted portion
- Preserve rest of content unchanged
- Maintain cursor position after conversion

#### Smart Format Detection & Auto-Suggest
- Analyze pasted text pattern
- Auto-suggest most likely desired conversion
- Detect ALL CAPS → suggest sentence/title case
- Detect all lowercase → suggest title case
- Show suggestion as subtle tooltip

#### "Fix My Mess" Intelligent Repair
- Detect accidental caps lock (THis IS WHen...)
- Fix aLtErNaTiNg CaSe
- Repair PDF paste issues (broken line breaks, hyphens)
- Fix smart quotes and special characters from Word
- Remove extra spaces and normalize whitespace

#### Comprehensive Style Guide Engine
- AP, MLA, Chicago, APA, NYT, Wikipedia, Bluebook, AMA
- IEEE, Harvard, Vancouver, OSCOLA
- AP Broadcast, Reuters, Bloomberg
- Oxford, Cambridge styles
- Each with proper rules for articles, prepositions, conjunctions

#### Visual Diff Highlighting
- Split view: Original | Converted
- Highlight changed words in subtle green
- Show character/word count for both
- Toggle diff view on/off

#### Structure & Formatting Preservation
- Maintain numbered lists (1. 2. 3.)
- Maintain bullet points (-, *, •)
- Preserve indentation and spacing
- Keep paragraph breaks
- Maintain nested list structure

#### Acronym & Abbreviation Intelligence
- Built-in dictionary of common acronyms (USA, FBI, CEO, HTML, etc.)
- Roman numeral detection and preservation
- Academic titles (PhD, MD, MBA)
- Time markers (AM, PM, BC, AD)

#### Contraction & Possessive Handling
- Proper capitalization of contractions (can't → Can't)
- Handle possessives correctly (james's → James's)
- Special cases (it's vs Its in titles)

### 4. User Experience Features

#### Recent Conversions Sidebar
- Store last 50 conversions in localStorage
- One-click restore any previous conversion
- Pin favorites
- Clear history option
- Search through history

#### Batch Line Processing
- Option to convert line-by-line
- Option to convert as single block
- Option to convert paragraph-by-paragraph
- Maintain line structure

#### Smart Copy Options
- Copy as plain text
- Copy with rich formatting preserved
- Copy as Markdown
- Copy as HTML
- Auto-copy on conversion (toggleable)

#### Keyboard Shortcuts
- Cmd/Ctrl + 1-5: Quick convert to top 5 formats
- Cmd/Ctrl + Enter: Apply and copy
- Tab: Cycle through style guides
- Escape: Clear text area

#### Word Hover Explanations
- Hover over any word to see why it changed
- Tooltip explains style guide rule
- Educational without being intrusive

#### User Preference Memory
- Remember default style guide
- Remember preservation preferences
- Remember recent custom terms
- Remember UI preferences (diff view, etc.)
- No account required - all localStorage

### 5. Advanced Features

#### Common Writing Scenarios
- Book title formatter
- Email subject line optimizer
- Headline variations generator
- Academic paper title formatter

#### Import/Export Capabilities
- Export settings as JSON
- Import settings from JSON
- Export conversion history
- Batch import multiple texts

#### Performance Features
- Instant conversion (no page reload)
- Handle texts up to 50,000 characters
- Debounced auto-save to localStorage
- Efficient diff algorithm

#### Accessibility Features
- Full keyboard navigation
- Screen reader friendly
- High contrast mode toggle
- Adjustable font size for text areas

## Implementation Status

### Currently Completed ✅
- Basic text transformations (15 styles)
- Style guide implementations (8 guides)
- Copy to clipboard functionality
- Real-time statistics tracking
- Responsive design with Tailwind CSS
- Input validation and error handling
- Basic accessibility improvements
- 100% test coverage for existing features

### To Be Implemented 🚧
- Additional case styles (11 more styles)
- Additional style guides (8 more guides)
- Smart preservation system
- Multi-level undo/redo
- Partial text selection conversion
- Smart format detection
- "Fix My Mess" intelligent repair
- Visual diff highlighting
- Structure preservation
- Acronym intelligence
- Recent conversions sidebar
- Batch processing options
- Smart copy options
- Keyboard shortcuts
- Word hover explanations
- User preference memory
- Import/export capabilities
- Performance optimizations
- Enhanced accessibility

## Technical Requirements

### Performance
- Handle texts up to 50,000 characters
- Instant conversion with no page reload
- Debounced auto-save to localStorage
- Efficient diff algorithm for comparisons

### Browser Support
- Chrome, Firefox, Safari, Edge (latest 2 versions)
- Progressive enhancement for older browsers
- Mobile-responsive for all screen sizes

### Security
- XSS prevention
- Input sanitization
- Content Security Policy headers
- Rate limiting for API endpoints

### Data Storage
- localStorage for user preferences
- IndexedDB for conversion history
- No personal data collection
- GDPR compliant

## Success Metrics
- Support for 50+ text transformation styles
- 16 professional style guide implementations
- < 100ms conversion time for average text
- 100% keyboard accessible
- Zero runtime errors in production
- 95%+ user satisfaction rating

## Project Constraints
- Client-side processing where possible
- No user accounts required
- Free to use without limitations
- Open source friendly
- Mobile-first design approach

## Documentation Requirements
- Comprehensive user guide
- API documentation for developers
- Style guide rule explanations
- Keyboard shortcut reference
- Accessibility documentation
- Performance benchmarks

## Target Audience
- Content writers and editors
- Academic researchers
- Web developers
- Social media managers
- Students and educators
- Legal professionals
- Marketing professionals
- Technical writers

## Technical Stack
- **Backend:** Laravel 11 with Livewire 3
- **Frontend:** Tailwind CSS v3.4.17, Alpine.js
- **Build Tools:** Vite, PostCSS
- **Database:** SQLite (development)
- **Testing:** PHPUnit for backend, manual browser validation

**Project Status:** CORE FEATURES COMPLETE - EXPANDING TO FULL FEATURE SET