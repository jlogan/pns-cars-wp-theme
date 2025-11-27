/**
 * Pre-fill Gutenberg blocks with ACF option data
 */
(function() {
	if (typeof wp === 'undefined' || !wp.hooks) {
		return;
	}

	const { addFilter } = wp.hooks;

	// Pre-fill block attributes when blocks are registered
	addFilter(
		'blocks.registerBlockType',
		'pns-cars/prefill-blocks',
		function(settings, name) {
			if (!window.pnsCarsACFData) {
				return settings;
			}

		// Override default attributes with ACF data (only if attributes exist)
		if (!settings.attributes) {
			return settings;
		}

		if (name === 'pns-cars/hero' && window.pnsCarsACFData.hero) {
			if (settings.attributes.headline) {
				settings.attributes.headline.default = window.pnsCarsACFData.hero.headline || '';
			}
			if (settings.attributes.subheadline) {
				settings.attributes.subheadline.default = window.pnsCarsACFData.hero.subheadline || '';
			}
			if (settings.attributes.ctaPrimary) {
				settings.attributes.ctaPrimary.default = window.pnsCarsACFData.hero.ctaPrimary || '';
			}
			if (settings.attributes.ctaSecondary) {
				settings.attributes.ctaSecondary.default = window.pnsCarsACFData.hero.ctaSecondary || '';
			}
		} else if (name === 'pns-cars/how-it-works' && window.pnsCarsACFData.howItWorks) {
			if (settings.attributes.heading) {
				settings.attributes.heading.default = window.pnsCarsACFData.howItWorks.heading || 'How It Works';
			}
			if (settings.attributes.steps && window.pnsCarsACFData.howItWorks.steps && window.pnsCarsACFData.howItWorks.steps.length > 0) {
				settings.attributes.steps.default = window.pnsCarsACFData.howItWorks.steps;
			}
		} else if (name === 'pns-cars/services' && window.pnsCarsACFData.services) {
			if (settings.attributes.heading) {
				settings.attributes.heading.default = window.pnsCarsACFData.services.heading || 'Benefits for Drivers';
			}
			if (settings.attributes.services && window.pnsCarsACFData.services.services && window.pnsCarsACFData.services.services.length > 0) {
				settings.attributes.services.default = window.pnsCarsACFData.services.services;
			}
		} else if (name === 'pns-cars/vehicles' && window.pnsCarsACFData.vehicles) {
			if (settings.attributes.heading) {
				settings.attributes.heading.default = window.pnsCarsACFData.vehicles.heading || 'Available Vehicles';
			}
			if (settings.attributes.count) {
				settings.attributes.count.default = window.pnsCarsACFData.vehicles.count !== undefined ? window.pnsCarsACFData.vehicles.count : -1;
			}
			if (settings.attributes.perRow) {
				settings.attributes.perRow.default = window.pnsCarsACFData.vehicles.perRow || 3;
			}
		} else if (name === 'pns-cars/pricing' && window.pnsCarsACFData.pricing) {
			if (settings.attributes.headline) {
				settings.attributes.headline.default = window.pnsCarsACFData.pricing.headline || '';
			}
			if (settings.attributes.content) {
				settings.attributes.content.default = window.pnsCarsACFData.pricing.content || '';
			}
		} else if (name === 'pns-cars/faq' && window.pnsCarsACFData.faq) {
			if (settings.attributes.heading) {
				settings.attributes.heading.default = window.pnsCarsACFData.faq.heading || 'Frequently Asked Questions';
			}
			if (settings.attributes.faqs && window.pnsCarsACFData.faq.faqs && window.pnsCarsACFData.faq.faqs.length > 0) {
				settings.attributes.faqs.default = window.pnsCarsACFData.faq.faqs;
			}
		} else if (name === 'pns-cars/location' && window.pnsCarsACFData.location) {
			if (settings.attributes.heading) {
				settings.attributes.heading.default = window.pnsCarsACFData.location.heading || 'Find Us';
			}
			if (settings.attributes.addressText) {
				settings.attributes.addressText.default = window.pnsCarsACFData.location.addressText || '';
			}
			if (settings.attributes.mapLink) {
				settings.attributes.mapLink.default = window.pnsCarsACFData.location.mapLink || '';
			}
			if (settings.attributes.googleMapsEmbedUrl) {
				settings.attributes.googleMapsEmbedUrl.default = window.pnsCarsACFData.location.googleMapsEmbedUrl || '';
			}
		}

			return settings;
		}
	);
})();

