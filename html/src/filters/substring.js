/**
 * Created by lengbin on 2017/7/9.
 */

module.exports = (string, number) => {
    let num = number | 10;
    if (string.length > num) {
        string = string.substring(0, num) + '...';
    }
    return string;
};
