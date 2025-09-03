import { TransformationMethod, Validators } from './base.js';

/**
 * Base class for text effect transformations
 */
class TextEffectTransformation extends TransformationMethod {
    constructor(name, description) {
        super(name, 'Text Effects', description);
        this.addValidator(Validators.required);
    }
}

/**
 * Aesthetic text transformation
 */
export class AestheticText extends TextEffectTransformation {
    constructor() {
        super('aesthetic', 'ａｅｓｔｈｅｔｉｃ ｔｅｘｔ');
    }

    execute(input) {
        const charMap = {
            ' ': '　',
            '!': '！', '"': '＂', '#': '＃', '$': '＄', '%': '％', '&': '＆',
            "'": '＇', '(': '（', ')': '）', '*': '＊', '+': '＋', ',': '，',
            '-': '－', '.': '．', '/': '／', '0': '０', '1': '１', '2': '２',
            '3': '３', '4': '４', '5': '５', '6': '６', '7': '７', '8': '８',
            '9': '９', ':': '：', ';': '；', '<': '＜', '=': '＝', '>': '＞',
            '?': '？', '@': '＠',
            'A': 'Ａ', 'B': 'Ｂ', 'C': 'Ｃ', 'D': 'Ｄ', 'E': 'Ｅ', 'F': 'Ｆ',
            'G': 'Ｇ', 'H': 'Ｈ', 'I': 'Ｉ', 'J': 'Ｊ', 'K': 'Ｋ', 'L': 'Ｌ',
            'M': 'Ｍ', 'N': 'Ｎ', 'O': 'Ｏ', 'P': 'Ｐ', 'Q': 'Ｑ', 'R': 'Ｒ',
            'S': 'Ｓ', 'T': 'Ｔ', 'U': 'Ｕ', 'V': 'Ｖ', 'W': 'Ｗ', 'X': 'Ｘ',
            'Y': 'Ｙ', 'Z': 'Ｚ',
            'a': 'ａ', 'b': 'ｂ', 'c': 'ｃ', 'd': 'ｄ', 'e': 'ｅ', 'f': 'ｆ',
            'g': 'ｇ', 'h': 'ｈ', 'i': 'ｉ', 'j': 'ｊ', 'k': 'ｋ', 'l': 'ｌ',
            'm': 'ｍ', 'n': 'ｎ', 'o': 'ｏ', 'p': 'ｐ', 'q': 'ｑ', 'r': 'ｒ',
            's': 'ｓ', 't': 'ｔ', 'u': 'ｕ', 'v': 'ｖ', 'w': 'ｗ', 'x': 'ｘ',
            'y': 'ｙ', 'z': 'ｚ'
        };
        
        return input.split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Small Caps transformation
 */
export class SmallCaps extends TextEffectTransformation {
    constructor() {
        super('smallcaps', 'Sᴍᴀʟʟ Cᴀᴘs Tᴇxᴛ');
    }

    execute(input) {
        const charMap = {
            'a': 'ᴀ', 'b': 'ʙ', 'c': 'ᴄ', 'd': 'ᴅ', 'e': 'ᴇ', 'f': 'ꜰ',
            'g': 'ɢ', 'h': 'ʜ', 'i': 'ɪ', 'j': 'ᴊ', 'k': 'ᴋ', 'l': 'ʟ',
            'm': 'ᴍ', 'n': 'ɴ', 'o': 'ᴏ', 'p': 'ᴘ', 'q': 'ǫ', 'r': 'ʀ',
            's': 's', 't': 'ᴛ', 'u': 'ᴜ', 'v': 'ᴠ', 'w': 'ᴡ', 'x': 'x',
            'y': 'ʏ', 'z': 'ᴢ'
        };
        
        return input.split('').map(char => {
            const lower = char.toLowerCase();
            if (char === char.toUpperCase() && charMap[lower]) {
                return char; // Keep uppercase as is
            }
            return charMap[lower] || char;
        }).join('');
    }
}

/**
 * Bubble Text transformation
 */
export class BubbleText extends TextEffectTransformation {
    constructor() {
        super('bubble', 'Ⓑⓤⓑⓑⓛⓔ Ⓣⓔⓧⓣ');
    }

    execute(input) {
        const charMap = {
            'A': 'Ⓐ', 'B': 'Ⓑ', 'C': 'Ⓒ', 'D': 'Ⓓ', 'E': 'Ⓔ', 'F': 'Ⓕ',
            'G': 'Ⓖ', 'H': 'Ⓗ', 'I': 'Ⓘ', 'J': 'Ⓙ', 'K': 'Ⓚ', 'L': 'Ⓛ',
            'M': 'Ⓜ', 'N': 'Ⓝ', 'O': 'Ⓞ', 'P': 'Ⓟ', 'Q': 'Ⓠ', 'R': 'Ⓡ',
            'S': 'Ⓢ', 'T': 'Ⓣ', 'U': 'Ⓤ', 'V': 'Ⓥ', 'W': 'Ⓦ', 'X': 'Ⓧ',
            'Y': 'Ⓨ', 'Z': 'Ⓩ',
            'a': 'ⓐ', 'b': 'ⓑ', 'c': 'ⓒ', 'd': 'ⓓ', 'e': 'ⓔ', 'f': 'ⓕ',
            'g': 'ⓖ', 'h': 'ⓗ', 'i': 'ⓘ', 'j': 'ⓙ', 'k': 'ⓚ', 'l': 'ⓛ',
            'm': 'ⓜ', 'n': 'ⓝ', 'o': 'ⓞ', 'p': 'ⓟ', 'q': 'ⓠ', 'r': 'ⓡ',
            's': 'ⓢ', 't': 'ⓣ', 'u': 'ⓤ', 'v': 'ⓥ', 'w': 'ⓦ', 'x': 'ⓧ',
            'y': 'ⓨ', 'z': 'ⓩ',
            '0': '⓪', '1': '①', '2': '②', '3': '③', '4': '④',
            '5': '⑤', '6': '⑥', '7': '⑦', '8': '⑧', '9': '⑨'
        };
        
        return input.split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Square Text transformation
 */
export class SquareText extends TextEffectTransformation {
    constructor() {
        super('square', '🅂🅀🅄🄰🅁🄴 🅃🄴🅇🅃');
    }

    execute(input) {
        const charMap = {
            'A': '🄰', 'B': '🄱', 'C': '🄲', 'D': '🄳', 'E': '🄴', 'F': '🄵',
            'G': '🄶', 'H': '🄷', 'I': '🄸', 'J': '🄹', 'K': '🄺', 'L': '🄻',
            'M': '🄼', 'N': '🄽', 'O': '🄾', 'P': '🄿', 'Q': '🅀', 'R': '🅁',
            'S': '🅂', 'T': '🅃', 'U': '🅄', 'V': '🅅', 'W': '🅆', 'X': '🅇',
            'Y': '🅈', 'Z': '🅉'
        };
        
        return input.toUpperCase().split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Script Text transformation
 */
export class ScriptText extends TextEffectTransformation {
    constructor() {
        super('script', '𝓢𝓬𝓻𝓲𝓹𝓽 𝓣𝓮𝔁𝓽');
    }

    execute(input) {
        const charMap = {
            'A': '𝓐', 'B': '𝓑', 'C': '𝓒', 'D': '𝓓', 'E': '𝓔', 'F': '𝓕',
            'G': '𝓖', 'H': '𝓗', 'I': '𝓘', 'J': '𝓙', 'K': '𝓚', 'L': '𝓛',
            'M': '𝓜', 'N': '𝓝', 'O': '𝓞', 'P': '𝓟', 'Q': '𝓠', 'R': '𝓡',
            'S': '𝓢', 'T': '𝓣', 'U': '𝓤', 'V': '𝓥', 'W': '𝓦', 'X': '𝓧',
            'Y': '𝓨', 'Z': '𝓩',
            'a': '𝓪', 'b': '𝓫', 'c': '𝓬', 'd': '𝓭', 'e': '𝓮', 'f': '𝓯',
            'g': '𝓰', 'h': '𝓱', 'i': '𝓲', 'j': '𝓳', 'k': '𝓴', 'l': '𝓵',
            'm': '𝓶', 'n': '𝓷', 'o': '𝓸', 'p': '𝓹', 'q': '𝓺', 'r': '𝓻',
            's': '𝓼', 't': '𝓽', 'u': '𝓾', 'v': '𝓿', 'w': '𝔀', 'x': '𝔁',
            'y': '𝔂', 'z': '𝔃'
        };
        
        return input.split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Double Struck Text transformation
 */
export class DoubleStruck extends TextEffectTransformation {
    constructor() {
        super('double-struck', '𝔻𝕠𝕦𝕓𝕝𝕖 𝕊𝕥𝕣𝕦𝕔𝕜');
    }

    execute(input) {
        const charMap = {
            'A': '𝔸', 'B': '𝔹', 'C': 'ℂ', 'D': '𝔻', 'E': '𝔼', 'F': '𝔽',
            'G': '𝔾', 'H': 'ℍ', 'I': '𝕀', 'J': '𝕁', 'K': '𝕂', 'L': '𝕃',
            'M': '𝕄', 'N': 'ℕ', 'O': '𝕆', 'P': 'ℙ', 'Q': 'ℚ', 'R': 'ℝ',
            'S': '𝕊', 'T': '𝕋', 'U': '𝕌', 'V': '𝕍', 'W': '𝕎', 'X': '𝕏',
            'Y': '𝕐', 'Z': 'ℤ',
            'a': '𝕒', 'b': '𝕓', 'c': '𝕔', 'd': '𝕕', 'e': '𝕖', 'f': '𝕗',
            'g': '𝕘', 'h': '𝕙', 'i': '𝕚', 'j': '𝕛', 'k': '𝕜', 'l': '𝕝',
            'm': '𝕞', 'n': '𝕟', 'o': '𝕠', 'p': '𝕡', 'q': '𝕢', 'r': '𝕣',
            's': '𝕤', 't': '𝕥', 'u': '𝕦', 'v': '𝕧', 'w': '𝕨', 'x': '𝕩',
            'y': '𝕪', 'z': '𝕫',
            '0': '𝟘', '1': '𝟙', '2': '𝟚', '3': '𝟛', '4': '𝟜',
            '5': '𝟝', '6': '𝟞', '7': '𝟟', '8': '𝟠', '9': '𝟡'
        };
        
        return input.split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Bold Text transformation (Unicode)
 */
export class BoldText extends TextEffectTransformation {
    constructor() {
        super('bold', '𝗕𝗼𝗹𝗱 𝗧𝗲𝘅𝘁');
    }

    execute(input) {
        const charMap = {
            'A': '𝗔', 'B': '𝗕', 'C': '𝗖', 'D': '𝗗', 'E': '𝗘', 'F': '𝗙',
            'G': '𝗚', 'H': '𝗛', 'I': '𝗜', 'J': '𝗝', 'K': '𝗞', 'L': '𝗟',
            'M': '𝗠', 'N': '𝗡', 'O': '𝗢', 'P': '𝗣', 'Q': '𝗤', 'R': '𝗥',
            'S': '𝗦', 'T': '𝗧', 'U': '𝗨', 'V': '𝗩', 'W': '𝗪', 'X': '𝗫',
            'Y': '𝗬', 'Z': '𝗭',
            'a': '𝗮', 'b': '𝗯', 'c': '𝗰', 'd': '𝗱', 'e': '𝗲', 'f': '𝗳',
            'g': '𝗴', 'h': '𝗵', 'i': '𝗶', 'j': '𝗷', 'k': '𝗸', 'l': '𝗹',
            'm': '𝗺', 'n': '𝗻', 'o': '𝗼', 'p': '𝗽', 'q': '𝗾', 'r': '𝗿',
            's': '𝘀', 't': '𝘁', 'u': '𝘂', 'v': '𝘃', 'w': '𝘄', 'x': '𝘅',
            'y': '𝘆', 'z': '𝘇',
            '0': '𝟬', '1': '𝟭', '2': '𝟮', '3': '𝟯', '4': '𝟰',
            '5': '𝟱', '6': '𝟲', '7': '𝟳', '8': '𝟴', '9': '𝟵'
        };
        
        return input.split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Italic Text transformation (Unicode)
 */
export class ItalicText extends TextEffectTransformation {
    constructor() {
        super('italic', '𝘐𝘵𝘢𝘭𝘪𝘤 𝘛𝘦𝘹𝘵');
    }

    execute(input) {
        const charMap = {
            'A': '𝘈', 'B': '𝘉', 'C': '𝘊', 'D': '𝘋', 'E': '𝘌', 'F': '𝘍',
            'G': '𝘎', 'H': '𝘏', 'I': '𝘐', 'J': '𝘑', 'K': '𝘒', 'L': '𝘓',
            'M': '𝘔', 'N': '𝘕', 'O': '𝘖', 'P': '𝘗', 'Q': '𝘘', 'R': '𝘙',
            'S': '𝘚', 'T': '𝘛', 'U': '𝘜', 'V': '𝘝', 'W': '𝘞', 'X': '𝘟',
            'Y': '𝘠', 'Z': '𝘡',
            'a': '𝘢', 'b': '𝘣', 'c': '𝘤', 'd': '𝘥', 'e': '𝘦', 'f': '𝘧',
            'g': '𝘨', 'h': '𝘩', 'i': '𝘪', 'j': '𝘫', 'k': '𝘬', 'l': '𝘭',
            'm': '𝘮', 'n': '𝘯', 'o': '𝘰', 'p': '𝘱', 'q': '𝘲', 'r': '𝘳',
            's': '𝘴', 't': '𝘵', 'u': '𝘶', 'v': '𝘷', 'w': '𝘸', 'x': '𝘹',
            'y': '𝘺', 'z': '𝘻'
        };
        
        return input.split('').map(char => charMap[char] || char).join('');
    }
}

/**
 * Emoji Case transformation
 */
export class EmojiCase extends TextEffectTransformation {
    constructor() {
        super('emoji-case', 'Add 🔥 emojis 💯 between 🎉 words');
    }

    execute(input) {
        const emojis = ['🔥', '💯', '✨', '🎉', '🚀', '💪', '⭐', '🌟', '💫', '🎯'];
        const words = input.split(/\s+/);
        
        return words.map((word, index) => {
            if (index < words.length - 1) {
                const emoji = emojis[Math.floor(Math.random() * emojis.length)];
                return word + ' ' + emoji;
            }
            return word;
        }).join(' ');
    }
}

/**
 * Upside Down Text transformation
 */
export class UpsideDown extends TextEffectTransformation {
    constructor() {
        super('upside-down', 'ʇxǝ⊥ uʍoᗡ ǝpᴉsd∩');
    }

    execute(input) {
        const charMap = {
            'a': 'ɐ', 'b': 'q', 'c': 'ɔ', 'd': 'p', 'e': 'ǝ', 'f': 'ɟ',
            'g': 'ƃ', 'h': 'ɥ', 'i': 'ᴉ', 'j': 'ɾ', 'k': 'ʞ', 'l': 'l',
            'm': 'ɯ', 'n': 'u', 'o': 'o', 'p': 'd', 'q': 'b', 'r': 'ɹ',
            's': 's', 't': 'ʇ', 'u': 'n', 'v': 'ʌ', 'w': 'ʍ', 'x': 'x',
            'y': 'ʎ', 'z': 'z',
            'A': '∀', 'B': 'ᗺ', 'C': 'Ɔ', 'D': 'ᗡ', 'E': 'Ǝ', 'F': 'Ⅎ',
            'G': '⅁', 'H': 'H', 'I': 'I', 'J': 'ſ', 'K': 'ʞ', 'L': '˥',
            'M': 'W', 'N': 'N', 'O': 'O', 'P': 'Ԁ', 'Q': 'Ό', 'R': 'ᴚ',
            'S': 'S', 'T': '⊥', 'U': '∩', 'V': 'Λ', 'W': 'M', 'X': 'X',
            'Y': '⅄', 'Z': 'Z',
            '1': 'Ɩ', '2': 'ᄅ', '3': 'Ɛ', '4': 'ㄣ', '5': 'ϛ',
            '6': '9', '7': 'ㄥ', '8': '8', '9': '6', '0': '0',
            '.': '˙', ',': '\'', '\'': ',', '"': '„', '!': '¡',
            '?': '¿', '(': ')', ')': '(', '[': ']', ']': '[',
            '{': '}', '}': '{', '<': '>', '>': '<', '&': '⅋',
            '_': '‾', '/': '\\', '\\': '/'
        };
        
        return input.split('').reverse().map(char => charMap[char] || char).join('');
    }
}

/**
 * Strikethrough Text transformation
 */
export class Strikethrough extends TextEffectTransformation {
    constructor() {
        super('strikethrough', 'S̶t̶r̶i̶k̶e̶t̶h̶r̶o̶u̶g̶h̶ ̶T̶e̶x̶t̶');
    }

    execute(input) {
        return input.split('').map(char => char + '\u0336').join('');
    }
}

/**
 * Underline Text transformation
 */
export class Underline extends TextEffectTransformation {
    constructor() {
        super('underline', 'U̲n̲d̲e̲r̲l̲i̲n̲e̲ ̲T̲e̲x̲t̲');
    }

    execute(input) {
        return input.split('').map(char => char + '\u0332').join('');
    }
}

/**
 * Zalgo Text transformation (Glitch text)
 */
export class ZalgoText extends TextEffectTransformation {
    constructor() {
        super('zalgo', 'Z̴̢̈́ą̵̈́l̸̡̈́g̷̨̈́ö̶̧́ ̶̨̈́T̴̢̈́ë̵́ẍ̸̡́ẗ̷̨́');
    }

    execute(input, options = {}) {
        const intensity = options.intensity || 'medium';
        const levels = {
            'low': 2,
            'medium': 5,
            'high': 10
        };
        const count = levels[intensity] || 5;
        
        // Zalgo characters
        const zalgoUp = ['̍', '̎', '̄', '̅', '̿', '̑', '̆', '̐', '͒', '͗'];
        const zalgoMid = ['̕', '̛', '̀', '́', '͘', '̡', '̢', '̧', '̨', '̴'];
        const zalgoDown = ['̖', '̗', '̘', '̙', '̜', '̝', '̞', '̟', '̠', '̤'];
        
        return input.split('').map(char => {
            let result = char;
            for (let i = 0; i < count; i++) {
                if (Math.random() > 0.5) result += zalgoUp[Math.floor(Math.random() * zalgoUp.length)];
                if (Math.random() > 0.5) result += zalgoMid[Math.floor(Math.random() * zalgoMid.length)];
                if (Math.random() > 0.5) result += zalgoDown[Math.floor(Math.random() * zalgoDown.length)];
            }
            return result;
        }).join('');
    }
}

// Export all transformations as an array
export const textEffectTransformations = [
    new AestheticText(),
    new SmallCaps(),
    new BubbleText(),
    new SquareText(),
    new ScriptText(),
    new DoubleStruck(),
    new BoldText(),
    new ItalicText(),
    new EmojiCase(),
    new UpsideDown(),
    new Strikethrough(),
    new Underline(),
    new ZalgoText()
];

export default textEffectTransformations;