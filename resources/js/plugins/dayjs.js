import dayjs from 'dayjs';
import customParseFormat from 'dayjs/plugin/customParseFormat';
import duration from 'dayjs/plugin/duration';
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import relativeTime from 'dayjs/plugin/relativeTime';
import timezone from 'dayjs/plugin/timezone';
import utc from 'dayjs/plugin/utc';

import 'dayjs/locale/en';
import 'dayjs/locale/tr';

dayjs.extend(utc);
dayjs.extend(duration);
dayjs.extend(relativeTime);
dayjs.extend(customParseFormat);
dayjs.extend(localizedFormat);
dayjs.extend(timezone);
dayjs.extend(isSameOrAfter);

// todo: make locale dynamic
dayjs.locale('tr');

dayjs.install = (app) => {
    app.config.globalProperties.$dayjs = dayjs;
    // provide in setup()
    app.provide('dayjs', dayjs);
};

export default dayjs;
