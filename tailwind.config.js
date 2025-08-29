/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Apple-style blue colors
        'apple': {
          'blue': '#007AFF',
          'blue-dark': '#0A84FF',
          'blue-darker': '#0051D5',
          'cyan': '#5AC8FA',
          'cyan-dark': '#32ADE6',
          'red': '#FF3B30',
          'green': '#34C759',
          'yellow': '#FFCC00',
          'orange': '#FF9500',
          'purple': '#AF52DE',
        },
        // Primary brand colors (updated to blue)
        'brand': {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#007AFF', // Apple blue
          600: '#0051D5', // Darker blue
          700: '#003D99',
          800: '#002966',
          900: '#001433',
          950: '#000A1A',
        },
        // Neutral grays for UI
        'surface': {
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0f172a',
          950: '#020617',
        },
      },
      backgroundColor: {
        'base': 'rgb(var(--color-bg-base) / <alpha-value>)',
        'surface': 'rgb(var(--color-bg-surface) / <alpha-value>)',
        'elevated': 'rgb(var(--color-bg-elevated) / <alpha-value>)',
      },
      textColor: {
        'primary': 'rgb(var(--color-text-primary) / <alpha-value>)',
        'secondary': 'rgb(var(--color-text-secondary) / <alpha-value>)',
        'tertiary': 'rgb(var(--color-text-tertiary) / <alpha-value>)',
      },
      borderColor: {
        'default': 'rgb(var(--color-border) / <alpha-value>)',
        'strong': 'rgb(var(--color-border-strong) / <alpha-value>)',
      },
      backdropBlur: {
        xs: '2px',
        sm: '4px',
        md: '8px',
        lg: '12px',
        xl: '16px',
        '2xl': '20px',
        '3xl': '40px',
      },
      backdropSaturate: {
        0: '0',
        50: '0.5',
        100: '1',
        150: '1.5',
        180: '1.8',
        200: '2',
      },
      backgroundImage: {
        'glass-gradient': 'linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%)',
        'glass-gradient-blue': 'linear-gradient(135deg, rgba(0, 122, 255, 0.1) 0%, rgba(10, 132, 255, 0.05) 100%)',
        'gradient-blue': 'linear-gradient(135deg, #007AFF 0%, #0051D5 100%)',
        'gradient-cyan': 'linear-gradient(135deg, #5AC8FA 0%, #32ADE6 100%)',
      },
      boxShadow: {
        'glass': '0 8px 32px rgba(0, 0, 0, 0.1)',
        'glass-sm': '0 4px 16px rgba(0, 0, 0, 0.08)',
        'glass-lg': '0 16px 48px rgba(0, 0, 0, 0.15)',
        'glass-blue': '0 8px 32px rgba(0, 122, 255, 0.2)',
        'glass-inset': 'inset 0 2px 4px rgba(0, 0, 0, 0.06)',
      },
      animation: {
        'float': 'float 6s ease-in-out infinite',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-20px)' },
        },
      },
    },
  },
  plugins: [],
}