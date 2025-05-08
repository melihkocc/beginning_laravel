const defaults = {
    prefix: '',
    suffix: '',
    thousands: ',',
    decimal: '.',
    precision: 2,
};

const options = defaults;

const format = (input, opt = defaults) => {
    if (typeof input === 'number') {
        input = input.toFixed(fixed(opt.precision));
    }
    var negative = input.indexOf('-') >= 0 ? '-' : '';

    var numbers = onlyNumbers(input);
    var currency = numbersToCurrency(numbers, opt.precision);
    var parts = toStr(currency).split('.');
    var integer = parts[0];
    var decimal = parts[1];
    integer = addThousandSeparator(integer, opt.thousands);
    return opt.prefix + negative + joinIntegerAndDecimal(integer, decimal, opt.decimal) + opt.suffix;
};

const onlyNumbers = (input) => {
    return toStr(input).replace(/\D+/g, '') || '0';
};

// Uncaught RangeError: toFixed() digits argument must be between 0 and 20 at Number.toFixed
const fixed = (precision) => {
    return between(0, precision, 20);
};

const between = (min, n, max) => {
    return Math.max(min, Math.min(n, max));
};

const numbersToCurrency = (numbers, precision) => {
    var exp = Math.pow(10, precision);
    var float = parseFloat(numbers) / exp;
    return float.toFixed(fixed(precision));
};

const addThousandSeparator = (integer, separator) => {
    return integer.replace(/(\d)(?=(?:\d{3})+\b)/gm, `$1${separator}`);
};

const joinIntegerAndDecimal = (integer, decimal, separator) => {
    return decimal ? integer + separator + decimal : integer;
};

const toStr = (value) => {
    return value ? value.toString() : '';
};

const setCursor = (el, position) => {
    var setSelectionRange = function () {
        el.setSelectionRange(position, position);
    };
    if (el === document.activeElement) {
        setSelectionRange();
        setTimeout(setSelectionRange, 1); // Android Fix
    }
};

// https://developer.mozilla.org/en-US/docs/Web/Guide/Events/Creating_and_triggering_events#The_old-fashioned_way
const event = (name) => {
    var evt = document.createEvent('Event');
    evt.initEvent(name, true, true);
    return evt;
};

const assign = (defaults, extras) => {
    defaults = defaults || {};
    extras = extras || {};
    return Object.keys(defaults)
        .concat(Object.keys(extras))
        .reduce(function (acc, val) {
            acc[val] = extras[val] === undefined ? defaults[val] : extras[val];
            return acc;
        }, {});
};

const install = (Vue, globalOptions) => {
    if (globalOptions) {
        Object.keys(globalOptions).map(function (key) {
            options[key] = globalOptions[key];
        });
    }
    Vue.directive('money', function (el, binding) {
        if (!binding.value) return;
        var opt = assign(defaults, binding.value);

        // v-money used on a component that's not a input
        if (el.tagName.toLocaleUpperCase() !== 'INPUT') {
            var els = el.getElementsByTagName('input');
            if (els.length !== 1) {
                // throw new Error("v-money requires 1 input, found " + els.length)
            } else {
                el = els[0];
            }
        }

        el.oninput = function () {
            var positionFromEnd = el.value.length - el.selectionEnd;
            el.value = format(el.value, opt);
            positionFromEnd = Math.max(positionFromEnd, opt.suffix.length); // right
            positionFromEnd = el.value.length - positionFromEnd;
            positionFromEnd = Math.max(positionFromEnd, opt.prefix.length + 1); // left
            setCursor(el, positionFromEnd);
            el.dispatchEvent(event('change')); // v-model.lazy
        };

        el.onfocus = function () {
            setCursor(el, el.value.length - opt.suffix.length);
        };

        el.oninput();
        el.dispatchEvent(event('input')); // force format after initialization
    });
};

export default install;
