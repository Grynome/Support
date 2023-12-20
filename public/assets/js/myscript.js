setInterval(function () {
    const now = new Date();

    const selisihWaktuElems = document.querySelectorAll('.dif-selisih-waktu');

    selisihWaktuElems.forEach(function (elem) {
        const datetimeFromDB = elem.getAttribute('data-datetime');

        const [dateStr, timeStr] = datetimeFromDB.split(' ');
        const [year, month, day] = dateStr.split('-');
        const [hour, minute, second] = timeStr.split(':');

        const datetimeObj = new Date(year, month - 1, day, hour, minute, second);

        let diffInSeconds = Math.floor((now.getTime() - datetimeObj.getTime()) / 1000);

        if (diffInSeconds >= 86400) {
            const diffInDays = Math.floor(diffInSeconds / 86400);
            diffInSeconds -= diffInDays * 86400;
            const diffInHours = Math.floor(diffInSeconds / 3600);
            diffInSeconds -= diffInHours * 3600;
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            diffInSeconds -= diffInMinutes * 60;
            elem.textContent =
                `${diffInDays} hari, ${diffInHours} jam, ${diffInMinutes} menit yang lalu`;
        } else if (diffInSeconds >=
            3600) {
            const diffInHours = Math.floor(diffInSeconds / 3600);
            diffInSeconds -= diffInHours * 3600;
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            diffInSeconds -= diffInMinutes * 60;
            elem.textContent = `${diffInHours} jam, ${diffInMinutes} menit yang lalu`;
        } else if (diffInSeconds >=
            60) {
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            diffInSeconds -= diffInMinutes * 60;
            elem.textContent = `${diffInMinutes} menit, ${diffInSeconds} detik yang lalu`;
        } else {
            elem.textContent = `${diffInSeconds} detik yang lalu`;
        }
    });
}, 1000);