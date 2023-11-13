const { __ } = wp.i18n;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;

const { PluginDocumentSettingPanel } = wp.editPost;
const { ToggleControl, PanelRow } = wp.components;

const Exclusion_Meta = ({ postMeta, setPostMeta }) => {

	// Return if meta is not set.
	if (undefined === postMeta) {
		return ("");
	}

	return (
		<PluginDocumentSettingPanel title={__('Analytify', 'wp-analytify-pro')} initialOpen="false" icon="analytify">
			<PanelRow>
				<ToggleControl
					label={__('Exclude this page from Google Analytics Tracking', 'wp-analytify-pro')}
					onChange={(value) => setPostMeta({ _analytify_skip_tracking: value })}
					checked={(undefined !== postMeta._analytify_skip_tracking) && postMeta._analytify_skip_tracking}
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	);
}

export default compose([
	withSelect((select) => {
		return {
			postMeta: select('core/editor').getEditedPostAttribute('meta'),
			postType: select('core/editor').getCurrentPostType(),
		};
	}),
	withDispatch((dispatch) => {
		return {
			setPostMeta(newMeta) {
				dispatch('core/editor').editPost({ meta: newMeta });
			}
		};
	})
])(Exclusion_Meta);