
function addFoldTrigger(settings, name) {
	if (typeof settings.attributes !== 'undefined') {
		if (name == 'core/calendar') {
			settings.attributes = Object.assign(settings.attributes, {
				matchNavBackground: {
					type: 'boolean',
				}
			});
		}
	}
	return settings;
}
 
wp.hooks.addFilter(
	'blocks.registerBlockType',
	'themes/Emm-bootstrap-base',
	addFoldTrigger
);

const foldControls = wp.compose.createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const { Fragment } = wp.element;
		const { ToggleControl } = wp.components;
		const { InspectorAdvancedControls } = wp.blockEditor;
		const { attributes, setAttributes, isSelected } = props;
		return (
			<React.Fragment>
				<BlockEdit {...props} />
				{isSelected && 
					<InspectorAdvancedControls>
						<ToggleControl
							label={wp.i18n.__('Match Nav Background on scroll', 'emm-bootstrap-base')}
							checked={!!attributes.hideOnMobile}
							onChange={(newval) => setAttributes({ matchNavBackground: !attributes.matchNavBackground })}
						/>
					</InspectorAdvancedControls>
				}
			</React.Fragment>
		);
	};
}, 'foldControls');
 
wp.hooks.addFilter(
	'editor.BlockEdit',
	'emm-bootstrap-base/fold-Controls',
	foldControls
);

function foldControlsClass(extraProps, blockType, attributes) {
	const { matchNavBackground } = attributes;
 
	if (typeof matchNavBackground !== 'undefined' && matchNavBackground) {
		extraProps.className = extraProps.className + ' fold';
	}
	return extraProps;
}
 
wp.hooks.addFilter(
	'blocks.getSaveContent.extraProps',
	'awp/fold-controls-class',
	foldControlsClass
);