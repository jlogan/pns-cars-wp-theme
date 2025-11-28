/**
 * Register PNS Cars Blocks with ACF-style Form Fields
 * Shows form fields in editor that sync with ACF options
 * Uses filter to modify existing blocks instead of unregistering/re-registering
 * This preserves the PHP render callback from block.json
 */
(function() {
	if (typeof wp === 'undefined' || !wp.blocks || !wp.element || !wp.hooks) {
		console.error('PNS Cars: Required WordPress packages not available');
		return;
	}

	const { addFilter, doAction } = wp.hooks;
	const { InspectorControls, useBlockProps, MediaUpload, MediaUploadCheck } = wp.blockEditor;
	const { PanelBody, TextControl, TextareaControl, RangeControl, Button } = wp.components;
	const { Fragment, useState } = wp.element;
	const { getBlockType, registerBlockType } = wp.blocks;

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
				{ key: 'ctaPrimaryLink', label: 'Primary CTA Link', type: 'text' },
				{ key: 'ctaSecondary', label: 'Secondary CTA Text', type: 'text' },
				{ key: 'ctaSecondaryLink', label: 'Secondary CTA Link', type: 'text' },
				{ key: 'partnersText', label: 'Partners Text', type: 'text' },
				{ key: 'partners', label: 'Partner Logos', type: 'array', itemFields: [
					{ key: 'image', label: 'Logo Image', type: 'image' },
					{ key: 'alt', label: 'Alt Text', type: 'text' },
					{ key: 'link', label: 'Link URL (optional)', type: 'text' }
				]},
				{ key: 'lifestyleImage', label: 'Lifestyle Background Image', type: 'image' },
				{ key: 'earningsHeader', label: 'Earnings App Header', type: 'text' },
				{ key: 'earningsAmount', label: 'Earnings Amount', type: 'text' },
				{ key: 'earningsSubtext', label: 'Earnings Subtext', type: 'text' },
				{ key: 'earningsOnline', label: 'Online Time', type: 'text' },
				{ key: 'earningsTips', label: 'Tips Amount', type: 'text' },
				{ key: 'notification1Icon', label: 'Notification 1 Icon (emoji)', type: 'text' },
				{ key: 'notification1Title', label: 'Notification 1 Title', type: 'text' },
				{ key: 'notification1Sub', label: 'Notification 1 Subtitle', type: 'text' },
				{ key: 'notification2Icon', label: 'Notification 2 Icon (emoji)', type: 'text' },
				{ key: 'notification2Title', label: 'Notification 2 Title', type: 'text' },
				{ key: 'notification2Sub', label: 'Notification 2 Subtitle', type: 'text' }
			]
		},
		{
			name: 'pns-cars/how-it-works',
			title: 'How It Works',
			icon: 'list-view',
			description: 'How it works section with steps',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'How It Works' },
				{ key: 'steps', label: 'Steps', type: 'array', itemFields: [
					{ key: 'title', label: 'Title', type: 'text' },
					{ key: 'description', label: 'Description', type: 'textarea' },
					{ key: 'icon', label: 'Icon (emoji)', type: 'text' }
				]}
			]
		},
		{
			name: 'pns-cars/services',
			title: 'Services',
			icon: 'star-filled',
			description: 'Services section with service cards',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Benefits for Drivers' },
				{ key: 'services', label: 'Services', type: 'array', itemFields: [
					{ key: 'title', label: 'Title', type: 'text' },
					{ key: 'description', label: 'Description', type: 'textarea' }
				]}
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
				{ key: 'introText', label: 'Intro Text', type: 'textarea' },
				{ key: 'listItems', label: 'List Items', type: 'array', itemFields: [
					{ key: 'item', label: 'Item Text', type: 'text' }
				]},
				{ key: 'buttonText', label: 'Button Text', type: 'text' },
				{ key: 'buttonLink', label: 'Button Link', type: 'text' }
			]
		},
		{
			name: 'pns-cars/faq',
			title: 'FAQ',
			icon: 'editor-help',
			description: 'FAQ section with questions and answers',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Frequently Asked Questions' },
				{ key: 'faqs', label: 'FAQs', type: 'array', itemFields: [
					{ key: 'question', label: 'Question', type: 'text' },
					{ key: 'answer', label: 'Answer', type: 'textarea' }
				]}
			]
		},
		{
			name: 'pns-cars/location',
			title: 'Location',
			icon: 'location',
			description: 'Location section with map and address',
			fields: [
				{ key: 'heading', label: 'Section Heading', type: 'text', default: 'Find Us' },
				{ key: 'addressText', label: 'Address Block (HTML allowed)', type: 'textarea', help: 'You can use HTML tags like &lt;br&gt; for line breaks' },
				{ key: 'servingText', label: 'Serving Text (HTML allowed)', type: 'textarea', help: 'You can use HTML tags for formatting' },
				{ key: 'mapLink', label: 'Map Link URL', type: 'text' },
				{ key: 'buttonText', label: 'Button Text', type: 'text' },
				{ key: 'googleMapsEmbedUrl', label: 'Google Maps Embed URL', type: 'textarea' }
			]
		}
	];

	// Create a map of block configs for quick lookup
	const blockConfigMap = {};
	blockConfigs.forEach(function(config) {
		blockConfigMap[config.name] = config;
	});

	// Block editor script loaded

	// Function to create edit component for a block
	function createEditComponent(blockConfig) {
		return function(props) {
			const blockProps = useBlockProps({
				className: 'pns-cars-block-editor'
			});

			const { attributes, setAttributes } = props;

			// Pre-fill attributes from ACF data if empty (only once)
			if (window.pnsCarsACFData && !attributes._prefilled) {
				let newAttrs = {};
				let shouldUpdate = false;

				if (blockConfig.name === 'pns-cars/hero' && window.pnsCarsACFData.hero) {
					// Pre-fill if any field is missing
					const heroData = window.pnsCarsACFData.hero;
					if (!attributes.headline || !attributes.subheadline || !attributes.ctaPrimary || !attributes.ctaSecondary ||
						!attributes.ctaPrimaryLink || !attributes.ctaSecondaryLink || !attributes.partnersText ||
						!attributes.lifestyleImage || !attributes.earningsHeader || !attributes.earningsAmount ||
						!attributes.earningsSubtext || !attributes.earningsOnline || !attributes.earningsTips ||
						!attributes.notification1Icon || !attributes.notification1Title || !attributes.notification1Sub ||
						!attributes.notification2Icon || !attributes.notification2Title || !attributes.notification2Sub) {
						newAttrs = {
							headline: attributes.headline || heroData.headline || '',
							subheadline: attributes.subheadline || heroData.subheadline || '',
							ctaPrimary: attributes.ctaPrimary || heroData.ctaPrimary || '',
							ctaPrimaryLink: attributes.ctaPrimaryLink || heroData.ctaPrimaryLink || '#vehicles',
							ctaSecondary: attributes.ctaSecondary || heroData.ctaSecondary || '',
							ctaSecondaryLink: attributes.ctaSecondaryLink || heroData.ctaSecondaryLink || '#booking',
							partnersText: attributes.partnersText || heroData.partnersText || 'Perfect for:',
							lifestyleImage: attributes.lifestyleImage || heroData.lifestyleImage || 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1000&auto=format&fit=crop',
							lifestyleImageId: attributes.lifestyleImageId || heroData.lifestyleImageId || null,
							earningsHeader: attributes.earningsHeader || heroData.earningsHeader || 'Weekly Earnings',
							earningsAmount: attributes.earningsAmount || heroData.earningsAmount || '1426.29',
							earningsSubtext: attributes.earningsSubtext || heroData.earningsSubtext || 'Oct 4 - Oct 10 • 33 Trips',
							earningsOnline: attributes.earningsOnline || heroData.earningsOnline || '20h 16m',
							earningsTips: attributes.earningsTips || heroData.earningsTips || '+$187.24',
							notification1Icon: attributes.notification1Icon || heroData.notification1Icon || '💰',
							notification1Title: attributes.notification1Title || heroData.notification1Title || 'Payout Processed',
							notification1Sub: attributes.notification1Sub || heroData.notification1Sub || 'You received $999.41',
							notification2Icon: attributes.notification2Icon || heroData.notification2Icon || '🚗',
							notification2Title: attributes.notification2Title || heroData.notification2Title || 'New Tip!',
							notification2Sub: attributes.notification2Sub || heroData.notification2Sub || '+$15.00 from Sarah',
							_prefilled: true
						};
						shouldUpdate = true;
					}
				} else if (blockConfig.name === 'pns-cars/how-it-works' && window.pnsCarsACFData.howItWorks) {
					// Pre-fill if heading is missing or steps array is empty
					const hasSteps = attributes.steps && Array.isArray(attributes.steps) && attributes.steps.length > 0;
					if (!attributes.heading || !hasSteps) {
						newAttrs = {
							heading: attributes.heading || window.pnsCarsACFData.howItWorks.heading || 'How It Works',
							steps: hasSteps ? attributes.steps : (window.pnsCarsACFData.howItWorks.steps || []),
							_prefilled: true
						};
						shouldUpdate = true;
					}
				} else if (blockConfig.name === 'pns-cars/services' && window.pnsCarsACFData.services) {
					// Pre-fill if heading is missing or services array is empty
					const hasServices = attributes.services && Array.isArray(attributes.services) && attributes.services.length > 0;
					if (!attributes.heading || !hasServices) {
						newAttrs = {
							heading: attributes.heading || window.pnsCarsACFData.services.heading || 'Benefits for Drivers',
							services: hasServices ? attributes.services : (window.pnsCarsACFData.services.services || []),
							_prefilled: true
						};
						shouldUpdate = true;
					}
				} else if (blockConfig.name === 'pns-cars/vehicles' && window.pnsCarsACFData.vehicles) {
					// Pre-fill if any field is missing
					if (!attributes.heading || attributes.count === undefined || attributes.perRow === undefined) {
						newAttrs = {
							heading: attributes.heading || window.pnsCarsACFData.vehicles.heading || 'Available Vehicles',
							count: attributes.count !== undefined ? attributes.count : (window.pnsCarsACFData.vehicles.count !== undefined ? window.pnsCarsACFData.vehicles.count : -1),
							perRow: attributes.perRow !== undefined ? attributes.perRow : (window.pnsCarsACFData.vehicles.perRow || 3),
							_prefilled: true
						};
						shouldUpdate = true;
					}
				} else if (blockConfig.name === 'pns-cars/pricing' && window.pnsCarsACFData.pricing) {
					// Pre-fill if any field is missing
					const hasListItems = attributes.listItems && Array.isArray(attributes.listItems) && attributes.listItems.length > 0;
					if (!attributes.headline || !attributes.introText || !hasListItems || !attributes.buttonText || !attributes.buttonLink) {
						// Convert list items array to object array format if needed
						let listItems = attributes.listItems || [];
						if (!hasListItems && window.pnsCarsACFData.pricing.listItems && Array.isArray(window.pnsCarsACFData.pricing.listItems)) {
							listItems = window.pnsCarsACFData.pricing.listItems.map(function(item) {
								return typeof item === 'string' ? { item: item } : item;
							});
						}
						if (listItems.length === 0) {
							listItems = [
								{ item: '$250 Refundable Deposit' },
								{ item: 'Weekly automatic payments' },
								{ item: 'Minimum 2-week rental' }
							];
						}
						newAttrs = {
							headline: attributes.headline || window.pnsCarsACFData.pricing.headline || '',
							introText: attributes.introText || window.pnsCarsACFData.pricing.introText || 'No hidden fees. One weekly price covers the car, insurance, and maintenance.',
							listItems: listItems,
							buttonText: attributes.buttonText || window.pnsCarsACFData.pricing.buttonText || 'Choose Your Car',
							buttonLink: attributes.buttonLink || window.pnsCarsACFData.pricing.buttonLink || '#vehicles',
							_prefilled: true
						};
						shouldUpdate = true;
					}
				} else if (blockConfig.name === 'pns-cars/faq' && window.pnsCarsACFData.faq) {
					// Pre-fill if heading is missing or faqs array is empty
					const hasFaqs = attributes.faqs && Array.isArray(attributes.faqs) && attributes.faqs.length > 0;
					if (!attributes.heading || !hasFaqs) {
						newAttrs = {
							heading: attributes.heading || window.pnsCarsACFData.faq.heading || 'Frequently Asked Questions',
							faqs: hasFaqs ? attributes.faqs : (window.pnsCarsACFData.faq.faqs || []),
							_prefilled: true
						};
						shouldUpdate = true;
					}
				} else if (blockConfig.name === 'pns-cars/location' && window.pnsCarsACFData.location) {
					// Pre-fill if any field is missing
					if (!attributes.heading || !attributes.addressText || !attributes.mapLink || !attributes.googleMapsEmbedUrl || !attributes.servingText || !attributes.buttonText) {
						newAttrs = {
							heading: attributes.heading || window.pnsCarsACFData.location.heading || 'Find Us',
							addressText: attributes.addressText || window.pnsCarsACFData.location.addressText || '',
							servingText: attributes.servingText || window.pnsCarsACFData.location.servingText || 'Serving the Atlanta Metro Area with reliable vehicles for gig drivers. Stop by our office to see the fleet in person.',
							mapLink: attributes.mapLink || window.pnsCarsACFData.location.mapLink || '',
							buttonText: attributes.buttonText || window.pnsCarsACFData.location.buttonText || 'Get Directions',
							googleMapsEmbedUrl: attributes.googleMapsEmbedUrl || window.pnsCarsACFData.location.googleMapsEmbedUrl || '',
							_prefilled: true
						};
						shouldUpdate = true;
					}
				}

				if (shouldUpdate) {
					setAttributes(newAttrs);
				}
			}

				// Helper function to render image field with upload option
				function renderImageField(field) {
					const imageValue = attributes[field.key] || '';
					const imageId = attributes[field.key + 'Id'] || null;
					
					return wp.element.createElement('div', { key: field.key, style: { marginBottom: '20px' } },
						wp.element.createElement('label', { style: { display: 'block', marginBottom: '8px', fontWeight: '600' } }, field.label),
						wp.element.createElement(MediaUploadCheck, {},
							wp.element.createElement(MediaUpload, {
								onSelect: function(media) {
									setAttributes({
										[field.key]: media.url || media.sizes?.full?.url || '',
										[field.key + 'Id']: media.id || null
									});
								},
								allowedTypes: ['image'],
								value: imageId,
								render: function(obj) {
									return wp.element.createElement(Button, {
										onClick: obj.open,
										isSecondary: true,
										style: { marginBottom: '10px', width: '100%' }
									}, imageId ? 'Replace Image' : 'Select Image from Media Library');
								}
							})
						),
						imageValue && wp.element.createElement('div', { style: { marginBottom: '10px' } },
							wp.element.createElement('img', {
								src: imageValue,
								alt: '',
								style: {
									width: '100%',
									maxHeight: '200px',
									objectFit: 'cover',
									borderRadius: '4px',
									border: '1px solid #ddd'
								}
							})
						),
						wp.element.createElement(TextControl, {
							label: 'Or enter image URL',
							value: imageValue,
							onChange: function(value) {
								setAttributes({ 
									[field.key]: value,
									[field.key + 'Id']: null // Clear ID when URL is manually entered
								});
							},
							placeholder: 'https://example.com/image.jpg',
							__next40pxDefaultSize: true,
							__nextHasNoMarginBottom: true
						}),
						(imageId || imageValue) && wp.element.createElement(Button, {
							isDestructive: true,
							isSmall: true,
							onClick: function() {
								setAttributes({
									[field.key]: '',
									[field.key + 'Id']: null
								});
							},
							style: { marginTop: '10px' }
						}, 'Remove Image')
					);
				}

				// Helper function to render array field
				function renderArrayField(field) {
					const arrayValue = attributes[field.key] || [];
					const itemFields = field.itemFields || [];
					
					return wp.element.createElement('div', { key: field.key, style: { marginBottom: '20px' } },
						wp.element.createElement('div', { style: { display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '10px' } },
							wp.element.createElement('strong', {}, field.label),
							wp.element.createElement(Button, {
								isSmall: true,
								isPrimary: true,
								onClick: function() {
									const newItem = {};
									itemFields.forEach(function(itemField) {
										newItem[itemField.key] = itemField.default || '';
									});
									setAttributes({
										[field.key]: [...arrayValue, newItem]
									});
								}
							}, 'Add Item')
						),
						arrayValue.map(function(item, index) {
							return wp.element.createElement('div', {
								key: index,
								style: {
									border: '1px solid #ddd',
									padding: '15px',
									marginBottom: '10px',
									borderRadius: '4px',
									background: '#f9f9f9'
								}
							},
								wp.element.createElement('div', { style: { display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '10px' } },
									wp.element.createElement('strong', {}, 'Item ' + (index + 1)),
									wp.element.createElement(Button, {
										isSmall: true,
										isDestructive: true,
										onClick: function() {
											const newArray = arrayValue.filter(function(_, i) { return i !== index; });
											setAttributes({ [field.key]: newArray });
										}
									}, 'Remove')
								),
								itemFields.map(function(itemField) {
									if (itemField.type === 'textarea') {
										return wp.element.createElement(TextareaControl, {
											key: itemField.key,
											label: itemField.label,
											value: item[itemField.key] || '',
											onChange: function(value) {
												const newArray = [...arrayValue];
												newArray[index] = { ...newArray[index], [itemField.key]: value };
												setAttributes({ [field.key]: newArray });
											},
											rows: 3,
											__nextHasNoMarginBottom: true
										});
									} else {
										return wp.element.createElement(TextControl, {
											key: itemField.key,
											label: itemField.label,
											value: item[itemField.key] || '',
											onChange: function(value) {
												const newArray = [...arrayValue];
												newArray[index] = { ...newArray[index], [itemField.key]: value };
												setAttributes({ [field.key]: newArray });
											},
											__next40pxDefaultSize: true,
											__nextHasNoMarginBottom: true
										});
									}
								})
							);
						}),
						arrayValue.length === 0 && wp.element.createElement('p', { style: { color: '#666', fontStyle: 'italic' } }, 'No items. Click "Add Item" to add one.')
					);
				}

				// Render form fields
				return wp.element.createElement(
					Fragment,
					{},
					wp.element.createElement(InspectorControls, {},
						wp.element.createElement(PanelBody, { title: blockConfig.title, initialOpen: true },
							blockConfig.fields.map(function(field) {
								if (field.type === 'image') {
									return renderImageField(field);
								} else if (field.type === 'array') {
									return renderArrayField(field);
								} else if (field.type === 'textarea') {
									return wp.element.createElement(TextareaControl, {
										key: field.key,
										label: field.label,
										value: attributes[field.key] || '',
										onChange: function(value) {
											setAttributes({ [field.key]: value });
										},
										rows: field.key === 'googleMapsEmbedUrl' ? 3 : 4,
										__nextHasNoMarginBottom: true
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
										allowReset: true,
										__next40pxDefaultSize: true,
										__nextHasNoMarginBottom: true
									});
								} else {
									return wp.element.createElement(TextControl, {
										key: field.key,
										label: field.label,
										value: attributes[field.key] || '',
										onChange: function(value) {
											setAttributes({ [field.key]: value });
										},
										__next40pxDefaultSize: true,
										__nextHasNoMarginBottom: true
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
		};
	}

	// Use filter to modify block settings instead of unregistering
	// This preserves the render callback from block.json
	// Use a high priority to ensure it runs after blocks are registered
	addFilter(
		'blocks.registerBlockType',
		'pns-cars/add-edit-component',
		function(settings, name) {
			// Only process PNS Cars blocks
			if (!name || name.indexOf('pns-cars/') !== 0) {
				return settings;
			}

			const blockConfig = blockConfigMap[name];
			if (!blockConfig) {
				if (window.console && console.warn) {
					console.warn('PNS Cars: Block config not found for', name);
				}
				return settings;
			}

			// Ensure settings is an object and has required properties
			if (!settings || typeof settings !== 'object') {
				if (window.console && console.warn) {
					console.warn('PNS Cars: Invalid settings for', name, settings);
				}
				return settings;
			}

			// Debug log
			if (window.console && console.log) {
				console.log('PNS Cars: Modifying block', name);
			}

			// Create edit component
			const editComponent = createEditComponent(blockConfig);

			// Modify settings to add edit component and ensure save returns null
			// This preserves the render callback from block.json and all other properties
			// Only modify the edit and save functions, preserve everything else
			settings.edit = editComponent;
			settings.save = function() {
				return null; // Dynamic block - rendered server-side
			};

			return settings;
		},
		20 // High priority to ensure it runs after other filters
	);

	// Wait for WordPress to bootstrap server-side blocks, then check and register if needed
	// WordPress bootstraps server blocks via wp.blocks.unstable__bootstrapServerSideBlockDefinitions
	// We need to wait for that to complete, then check if our blocks are registered
	// Track which blocks we've already registered to avoid duplicate warnings
	const registeredBlocks = new Set();
	
	// Function to register a single block if not already registered
	function registerBlockIfNeeded(config) {
		// Skip if already registered
		if (registeredBlocks.has(config.name)) {
			return;
		}
		
		let block = getBlockType(config.name);
		
		if (!block) {
			// Block not found - register it manually
				// Build attributes from block config
				const attributes = {};
				config.fields.forEach(function(field) {
					if (field.type === 'array') {
						attributes[field.key] = {
							type: 'array',
							default: []
						};
					} else if (field.type === 'image') {
						attributes[field.key] = {
							type: 'string',
							default: field.default !== undefined ? field.default : ''
						};
						// Add image ID attribute for media library uploads
						attributes[field.key + 'Id'] = {
							type: 'number',
							default: null
						};
					} else if (field.type === 'number') {
						attributes[field.key] = {
							type: 'number',
							default: field.default !== undefined ? field.default : 0
						};
					} else {
						attributes[field.key] = {
							type: 'string',
							default: field.default !== undefined ? field.default : ''
						};
					}
				});
			
			// Register the block manually
			try {
				registerBlockType(config.name, {
					title: config.title,
					icon: config.icon,
					category: 'pns-cars',
					description: config.description,
					attributes: attributes,
					edit: createEditComponent(config),
					save: function() {
						return null; // Dynamic block - rendered server-side
					}
				});
				
				// Verify it was registered
				const verifyBlock = getBlockType(config.name);
				if (verifyBlock) {
					registeredBlocks.add(config.name);
				}
			} catch (e) {
				console.error('PNS Cars: Failed to register block', config.name, e);
			}
		} else {
			// Block already exists
			registeredBlocks.add(config.name);
		}
	}

	// Register all blocks immediately
	blockConfigs.forEach(registerBlockIfNeeded);
	
	// Also check once after WordPress bootstraps server blocks (in case they were bootstrapped)
	if (wp.domReady) {
		wp.domReady(function() {
			setTimeout(function() {
				blockConfigs.forEach(registerBlockIfNeeded);
			}, 100);
		});
	}
})();
