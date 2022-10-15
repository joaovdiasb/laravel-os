const colors = require('tailwindcss/colors')

function withOpacityValue(variable) {
    return ({ opacityValue }) => {
        if (opacityValue === undefined) {
            return `rgb(var(${variable}))`
        }
        return `rgb(var(${variable}) / ${opacityValue})`
    }
}

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.red,
                primary: {
                    '50':  withOpacityValue('--color-primary-50'),
                    '100': withOpacityValue('--color-primary-100'),
                    '200': withOpacityValue('--color-primary-200'),
                    '300': withOpacityValue('--color-primary-300'),
                    '400': withOpacityValue('--color-primary-400'),
                    '500': withOpacityValue('--color-primary-500'),
                    '600': withOpacityValue('--color-primary-600'),
                    '700': withOpacityValue('--color-primary-700'),
                    '800': withOpacityValue('--color-primary-800'),
                    '900': withOpacityValue('--color-primary-900')
                },
                success: colors.green,
                warning: colors.yellow,
            },
        }
    },
    safelist: [
        'bg-yellow-100',
        'peer-checked:bg-yellow-100',
        'text-yellow-600',
        'peer-checked:border-yellow-600',
        'peer-checked:text-yellow-600',
        'peer-checked:bg-yellow-100',
        'bg-gray-100',
        'peer-checked:bg-gray-100',
        'text-gray-600',
        'peer-checked:border-gray-600',
        'peer-checked:text-gray-600',
        'peer-checked:bg-gray-100',
        'bg-green-100',
        'peer-checked:bg-green-100',
        'text-green-600',
        'peer-checked:border-green-600',
        'peer-checked:text-green-600',
        'bg-blue-100',
        'peer-checked:bg-blue-100',
        'text-blue-600',
        'peer-checked:border-blue-600',
        'peer-checked:text-blue-600',
    ],
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
