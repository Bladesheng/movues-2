<script setup lang="ts">
import { useTemplateRef } from 'vue';

const containerRef = useTemplateRef('container');
const contentRef = useTemplateRef('content');

function startDrag(e: MouseEvent) {
	const container = containerRef.value;
	const content = contentRef.value;

	if (!container || !content) {
		return;
	}

	const initialWidth = container.getBoundingClientRect().width;
	const initialHeight = container.getBoundingClientRect().height;
	const initialX = e.pageX;
	const initialY = e.pageY;
	const aspectRatio = initialWidth / initialHeight;

	// otherwise content would capture the mouseup events and you couldn't stop dragging
	content.classList.add('pointer-events-none');

	// to keep the width after cancelling max width
	container.style.width = initialWidth + 'px';
	container.style.maxWidth = 'none';

	document.addEventListener('mousemove', resize);
	document.addEventListener(
		'mouseup',
		() => {
			document.removeEventListener('mousemove', resize);
			content.classList.remove('pointer-events-none');
		},
		{
			once: true,
		}
	);

	function resize(e: MouseEvent) {
		const currentX = e.pageX;
		const currentY = e.pageY;

		const diffX = currentX - initialX;
		const diffY = currentY - initialY;

		// new width based only on movement in X axis
		const xMovementNewWidth = initialWidth + diffX;
		// container.style.width = xMovementNewWidth + 'px'; // (this is fine, but moving in Y axis wouldn't do anything)

		const yMovementNewHeight = initialHeight + diffY;
		// new width based only on movement in Y axis
		const yMovementNewWidth = yMovementNewHeight * aspectRatio;
		// container.style.width = yMovementNewWidth + 'px'; // (this is fine, but moving in X axis wouldn't do anything)

		// now we put both new widths together - basically a weighted average
		const newWidth =
			(xMovementNewWidth * initialWidth + yMovementNewWidth * initialHeight) /
			(initialWidth + initialHeight);

		if (newWidth < 200) {
			return;
		}

		container!.style.width = newWidth + 'px';
	}
}
</script>

<template>
	<div ref="container">
		<div ref="content">
			<slot />
		</div>

		<div class="flex">
			<button
				@mousedown="startDrag"
				class="btn btn-ghost btn-sm mt-1 ml-auto cursor-nwse-resize"
				title="drag to resize"
			>
				<span class="icon-[heroicons--arrow-down-right]"></span>
			</button>
		</div>
	</div>
</template>

<style scoped></style>
