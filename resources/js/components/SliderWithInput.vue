<script setup lang="ts">
import { computed } from 'vue';

const currentValue = defineModel<number>({
	required: true,
});

const {
	id,
	label,
	min = 0,
	max,
	step,
} = defineProps<{
	id: string;
	label: string;
	min?: number;
	max: number;
	step?: string;
}>();

function onWheel(e: WheelEvent) {
	// v-model isn't updated fast enough - the clamping would be done on the previous value (nothing would happen)
	let newValue = currentValue.value;

	if (e.deltaY > 0) {
		newValue -= 5;
	} else {
		newValue += 5;
	}

	if (newValue < min) {
		newValue = min;
	}

	if (newValue > max) {
		newValue = max;
	}

	currentValue.value = newValue;
}

const ariaLabel = computed(() => `${id}-label`);
</script>

<template>
	<fieldset @wheel.prevent="onWheel">
		<legend :id="ariaLabel">
			<label :for="id">
				{{ label }}
			</label>
		</legend>

		<div class="flex items-center gap-4">
			<input
				v-model.number="currentValue"
				:min
				:max
				:step
				type="range"
				class="range"
				:aria-labelledby="ariaLabel"
			/>
			<input
				v-model.number="currentValue"
				:id
				type="number"
				class="input w-14 text-center"
				:aria-labelledby="ariaLabel"
			/>
		</div>
	</fieldset>
</template>

<style scoped></style>
