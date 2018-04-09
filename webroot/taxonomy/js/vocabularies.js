const Vocabularies = {
    documentReady() {},
    slug() {
        $("#VocabularyAlias").slugify('#VocabularyTitle');
    }
};
$(function () {
    if (Croogo.params.controller === 'vocabularies') {
        Vocabularies.documentReady();
        if (Croogo.params.action === 'admin_add') {
            Vocabularies.slug();
        }
    }
});