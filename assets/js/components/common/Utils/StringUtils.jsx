function ucfirst(text) {
    return text.charAt(0).toUpperCase() + text.substr(1).toLowerCase();
}

const StringUtils = {
    ucfirst
};

export default StringUtils;