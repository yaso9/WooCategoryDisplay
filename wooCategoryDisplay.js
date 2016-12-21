(function ($) {
	$(document).ready(function () {
		$('.child').hide()
		$('.imgWooCategoryDisplay').css('object-fit', 'cover')

		$('.categoryDisplay').find('.categoryDisplayItem').each(function (index) {
			let info = $(this).find('.info').html().split(',')
			let isParent = info[0];

			if (!isParent) {
				$(this).on('click', function () {
					window.location.assign($(this).find('a').attr('href'))
			})
			}

			if (isParent) {
				$(this).find('a').on('click', function (event) {
					event.preventDefault()
				})
				$(this).on('click', function (event) {
					$(this).parents('.categoryDisplay').find('.categoryDisplayItem').not('child').hide()
					$(this).parents('.categoryDisplay').find('.categoryDisplayItem.child.' + info[1].trim()).show()
				})
			}
		})
	})
})(jQuery)
