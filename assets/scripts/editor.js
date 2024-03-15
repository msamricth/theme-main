function editorStuff() {
    function removeBlocks(editorSettings) {
        const { allowedBlocks } = editorSettings;

        // Define an array of block names to remove
        const blocksToRemove = [
            'core/image'
            // Add more block names here if needed
        ];

        // Filter out the blocks to remove from the allowedBlocks array
        editorSettings.allowedBlocks = allowedBlocks.filter(blockName => !blocksToRemove.includes(blockName));

        return editorSettings;
    }

    // Hook into the 'blocks.registerBlockType' filter to remove blocks
    wp.hooks.addFilter(
        'blocks.registerBlockType',
        'my-theme/remove-blocks',
        removeBlocks
    );
}
export{ editorStuff }