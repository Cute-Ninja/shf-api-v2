function ucfirst(text) {
    if (text instanceof String && text.length >= 2) {
        return text.charAt(0).toUpperCase() + text.substr(1).toLowerCase();
    }

    return text;
}

const StringUtils = {
    ucfirst
};

export default StringUtils;