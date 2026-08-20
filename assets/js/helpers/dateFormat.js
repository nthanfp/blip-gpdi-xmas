function formatDate(value) {
    if (!value) return '-';
    var date = new Date(value);
    if (isNaN(date)) return value;
    var day = String(date.getDate()).padStart(2, '0');
    var month = date.toLocaleString('en-US', { month: 'short' });
    var year = date.getFullYear();
    var hours = String(date.getHours()).padStart(2, '0');
    var minutes = String(date.getMinutes()).padStart(2, '0');
    return day + ' ' + month + ' ' + year + ' ' + hours + ':' + minutes;
}
