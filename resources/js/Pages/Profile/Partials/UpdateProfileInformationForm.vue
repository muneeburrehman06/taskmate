<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name ?? "",
    email: props.user.email ?? "",
    username: props.user.username ?? "",
    dob: props.user.dob ?? "",
    education: props.user.education ?? "",
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information.
        </template>

        <template #form>

            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                
                <!-- File Input -->
                <input
                    id="photo"
                    ref="photoInput"
                    type="file"
                    class=""
                    @change="updatePhotoPreview"
                >

                <InputLabel for="photo" value="Profile Photo" />

                <!-- Current Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img :src="user.profile_photo_url"
                         :alt="user.name"
                         class="rounded-full size-20 object-cover">
                </div>

                <!-- New Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span class="block rounded-full size-20 bg-cover bg-center"
                          :style="'background-image: url(' + photoPreview + ')'"></span>
                </div>

                <SecondaryButton class="mt-2 me-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </SecondaryButton>

                <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    Remove Photo
                </SecondaryButton>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Username -->
            <!-- <div class="col-span-6 sm:col-span-4">
                <InputLabel for="username" value="Username" />
                <TextInput
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.username" class="mt-2" />
            </div> -->

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <!-- <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                />
                <InputError :message="form.errors.email" class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 text-sm text-green-600">
                        A new verification link has been sent!
                    </div>
                </div>
            </div> -->

            <!-- DOB -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="dob" value="Date of Birth" />
                <TextInput
                    id="dob"
                    v-model="form.dob"
                    type="date"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.dob" class="mt-2" />
            </div>

            <!-- Education -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="education" value="Education" />
                <TextInput
                    id="education"
                    v-model="form.education"
                    type="text"
                    class="mt-1 block w-full"
                />
                <InputError :message="form.errors.education" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
