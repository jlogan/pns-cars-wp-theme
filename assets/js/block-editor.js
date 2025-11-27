/**
 * Register PNS Cars Blocks with ACF-style Form Fields
 * Shows form fields in editor that sync with ACF options
 */
(function() {
	if (typeof wp === 'undefined' || !wp.blocks || !wp.element) {
		return;
	}

	const { registerBlockType } = wp.blocks;
	const { InspectorControls, useBlockProps } = wp.blockEditor;
	const { PanelBody, TextControl, TextareaControl, RangeControl } = wp.components;
	const { Fragment } = wp.element;

	// Block configurations with field definitions matching ACF structure
	const blockConfigs = [
		{
			name: 'pns-cars/hero',
			title: 'Hero Section',
			icon: 'car',
			description: 'Hero section with headline, subheadline, and CTAs',
			fields: [
				{ key: 'headline', label: 'Headline', type: 'text' },
				{ key: 'subheadline', label: 'Subheadline', type: 'textarea' },
				{ key: 'ctaPrimary', label: 'Primary CTA Text', type: 'text' },
				{ key: 'ctaSecondary', label: 'Secondary CTA Text', type: 'text' }
			]
		},
		{
			name: 'pns-cars/how-it-works',
			title: 'How It Works',
			icon: 'list-view',
			description: 'How it works section with steps',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'How It Works' }
			]
		},
		{
			name: 'pns-cars/services',
			title: 'Services',
			icon: 'star-filled',
			description: 'Services section with service cards',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Benefits for Drivers' }
			]
		},
		{
			name: 'pns-cars/vehicles',
			title: 'Vehicles',
			icon: 'car',
			description: 'Vehicles section with inventory grid',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Available Vehicles' },
				{ key: 'count', label: 'Number of Items to Show', type: 'number', default: -1 },
				{ key: 'perRow', label: 'Items Per Row', type: 'number', default: 3, min: 1, max: 6 }
			]
		},
		{
			name: 'pns-cars/pricing',
			title: 'Pricing',
			icon: 'money-alt',
			description: 'Pricing section',
			fields: [
				{ key: 'headline', label: 'Pricing Headline', type: 'text' },
				{ key: 'content', label: 'Pricing Content', type: 'textarea' }
			]
		},
		{
			name: 'pns-cars/faq',
			title: 'FAQ',
			icon: 'editor-help',
			description: 'FAQ section with questions and answers',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Frequently Asked Questions' }
			]
		},
		{
			name: 'pns-cars/location',
			title: 'Location',
			icon: 'location',
			description: 'Location section with map and address',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Find Us' },
				{ key: 'addressText', label: 'Address Block', type: 'textarea' },
				{ key: 'mapLink', label: 'Map Link URL', type: 'text' },
				{ key: 'googleMapsEmbedUrl', label: 'Google Maps Embed URL', type: 'textarea' }
			]
		}
	];

	blockConfigs.forEach(function(blockConfig) {
		// Check if block already exists (registered via PHP)
		const existingBlock = wp.blocks.getBlockType(blockConfig.name);
		
		// Get attributes from existing block or use defaults
		let blockAttributes = {};
		if (existingBlock && existingBlock.attributes) {
			blockAttributes = existingBlock.attributes;
		} else {
			// Define default attributes
			blockConfig.fields.forEach(function(field) {
				blockAttributes[field.key] = {
					type: field.type === 'number' ? 'number' : 'string',
					default: field.default !== undefined ? field.default : ''
				};
			});
		}

		// Unregister if exists and re-register with edit component
		if (existingBlock) {
			wp.blocks.unregisterBlockType(blockConfig.name);
		}

		// Register block with ACF-style form fields
		registerBlockType(blockConfig.name, {
			title: blockConfig.title,
			icon: blockConfig.icon,
			category: 'pns-cars',
			description: blockConfig.description,
			attributes: blockAttributes,
			edit: function(props) {
				const blockProps = useBlockProps({
					className: 'pns-cars-block-editor'
				});

				const { attributes, setAttributes } = props;

				// Pre-fill attributes from ACF data if empty (only once)
				if (window.pnsCarsACFData && !attributes._prefilled) {
					let newAttrs = {};
					let shouldUpdate = false;

					if (blockConfig.name === 'pns-cars/hero' && window.pnsCarsACFData.hero) {
						if (!attributes.headline && window.pnsCarsACFData.hero.headline) {
							newAttrs = {
								headline: window.pnsCarsACFData.hero.headline || '',
								subheadline: window.pnsCarsACFData.hero.subheadline || '',
								ctaPrimary: window.pnsCarsACFData.hero.ctaPrimary || '',
								ctaSecondary: window.pnsCarsACFData.hero.ctaSecondary || '',
								_prefilled: true
							};
							shouldUpdate = true;
						}
					} else if (blockConfig.name === 'pns-cars/how-it-works' && window.pnsCarsACFData.howItWorks) {
						if (!attributes.heading && window.pnsCarsACFData.howItWorks.heading) {
							newAttrs = {
								heading: window.pnsCarsACFData.howItWorks.heading || 'How It Works',
								steps: window.pnsCarsACFData.howItWorks.steps || [],
								_prefilled: true
							};
							shouldUpdate = true;
						}
					} else if (blockConfig.name === 'pns-cars/services' && window.pnsCarsACFData.services) {
						if (!attributes.heading && window.pnsCarsACFData.services.heading) {
							newAttrs = {
								heading: window.pnsCarsACFData.services.heading || 'Benefits for Drivers',
								services: window.pnsCarsACFData.services.services || [],
								_prefilled: true
							};
							shouldUpdate = true;
						}
					} else if (blockConfig.name === 'pns-cars/vehicles' && window.pnsCarsACFData.vehicles) {
						if (!attributes.heading && window.pnsCarsACFData.vehicles.heading) {
							newAttrs = {
								heading: window.pnsCarsACFData.vehicles.heading || 'Available Vehicles',
								count: window.pnsCarsACFData.vehicles.count !== undefined ? window.pnsCarsACFData.vehicles.count : -1,
								perRow: window.pnsCarsACFData.vehicles.perRow || 3,
								_prefilled: true
							};
							shouldUpdate = true;
						}
					} else if (blockConfig.name === 'pns-cars/pricing' && window.pnsCarsACFData.pricing) {
						if (!attributes.headline && window.pnsCarsACFData.pricing.headline) {
							newAttrs = {
								headline: window.pnsCarsACFData.pricing.headline || '',
								content: window.pnsCarsACFData.pricing.content || '',
								_prefilled: true
							};
							shouldUpdate = true;
						}
					} else if (blockConfig.name === 'pns-cars/faq' && window.pnsCarsACFData.faq) {
						if (!attributes.heading && window.pnsCarsACFData.faq.heading) {
							newAttrs = {
								heading: window.pnsCarsACFData.faq.heading || 'Frequently Asked Questions',
								faqs: window.pnsCarsACFData.faq.faqs || [],
								_prefilled: true
							};
							shouldUpdate = true;
						}
					} else if (blockConfig.name === 'pns-cars/location' && window.pnsCarsACFData.location) {
						if (!attributes.heading && window.pnsCarsACFData.location.heading) {
							newAttrs = {
								heading: window.pnsCarsACFData.location.heading || 'Find Us',
								addressText: window.pnsCarsACFData.location.addressText || '',
								mapLink: window.pnsCarsACFData.location.mapLink || '',
								googleMapsEmbedUrl: window.pnsCarsACFData.location.googleMapsEmbedUrl || '',
								_prefilled: true
							};
							shouldUpdate = true;
						}
					}

					if (shouldUpdate) {
						setAttributes(newAttrs);
					}
				}

				// Render form fields
				return wp.element.createElement(
					Fragment,
					{},
					wp.element.createElement(InspectorControls, {},
						wp.element.createElement(PanelBody, { title: blockConfig.title, initialOpen: true },
							blockConfig.fields.map(function(field) {
								if (field.type === 'textarea') {
									return wp.element.createElement(TextareaControl, {
										key: field.key,
										label: field.label,
										value: attributes[field.key] || '',
										onChange: function(value) {
											setAttributes({ [field.key]: value });
										},
										rows: field.key === 'googleMapsEmbedUrl' ? 3 : 4
									});
								} else if (field.type === 'number') {
									return wp.element.createElement(RangeControl, {
										key: field.key,
										label: field.label,
										value: attributes[field.key] !== undefined ? attributes[field.key] : (field.default !== undefined ? field.default : 0),
										onChange: function(value) {
											setAttributes({ [field.key]: value });
										},
										min: field.min !== undefined ? field.min : 0,
										max: field.max !== undefined ? field.max : 100,
										allowReset: true
									});
								} else {
									return wp.element.createElement(TextControl, {
										key: field.key,
										label: field.label,
										value: attributes[field.key] || '',
										onChange: function(value) {
											setAttributes({ [field.key]: value });
										}
									});
								}
							})
						)
					),
					wp.element.createElement('div', blockProps,
						wp.element.createElement('div', {
							style: {
								padding: '20px',
								border: '1px dashed #ccc',
								background: '#f9f9f9',
								borderRadius: '4px'
							}
						},
							wp.element.createElement('strong', { style: { display: 'block', marginBottom: '10px' } },
								blockConfig.title
							),
							wp.element.createElement('p', { style: { margin: 0, color: '#666', fontSize: '13px' } },
								'Configure this block using the settings panel on the right.'
							)
						)
					)
				);
			},
			save: function() {
				return null;
			}
		});
	});
})();
