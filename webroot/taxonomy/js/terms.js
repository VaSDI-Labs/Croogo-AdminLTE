const Terms = {
    documentReady() {},
    slug (){
        $("#TermSlug").slugify('#TermTitle');
    }
};

$(function () {
	if (Croogo.params.controller === 'terms') {
		Terms.documentReady();
		if (Croogo.params.action === 'admin_add') {
			Terms.slug();
		}
	}
});