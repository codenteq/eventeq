import {Head, Link} from "@inertiajs/react";
import {Button} from "@codenteq/interfeys";
import MainLayout from "../Layouts/MainLayout.jsx";
import { Swiper, SwiperSlide } from 'swiper/react';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import {Navigation, Pagination} from "swiper/modules";
import {HeartIcon, StarIcon} from "@heroicons/react/24/outline/index.js";

export default function Welcome({ events }) {
    const slides = [
        { image_url: '/slide01.png' },
        { image_url: '/slide02.png' },
    ];

    return (
        <>
            <MainLayout>
                <Head>
                    <title>Eventeq</title>
                    <meta name="description" content="Etkinliklerinizi yönetin, başvuru yapın veya genel bilgi alın."/>
                    <meta property="og:title" content="Eventeq"/>
                    <meta property="og:description"
                          content="Etkinliklerinizi yönetin, başvuru yapın veya genel bilgi alın."/>
                    <meta property="og:url" content="https://eventeq.codenteq.com/"/>
                    <meta property="og:site_name" content="Eventeq"/>
                    <meta property="og:image"
                          content="https://codenteq.com/wp-content/uploads/2023/03/3d-logo-mockup-dark.webp"/>
                    <meta property="og:image:width" content="1080"/>
                    <meta property="og:image:height" content="720"/>
                    <meta property="og:image:type" content="image/webp"/>
                    <meta name="twitter:card" content="summary_large_image"/>
                    <meta name="twitter:title" content="Eventeq"/>
                    <meta name="twitter:description"
                          content="Etkinliklerinizi yönetin, başvuru yapın veya genel bilgi alın."/>
                    <meta name="twitter:image"
                          content="https://codenteq.com/wp-content/uploads/2023/03/3d-logo-mockup-dark.webp"/>

                </Head>
                <section className="container mx-auto py-10">
                    <Swiper
                        pagination={{clickable: false}}
                        navigation={false}
                        modules={[Pagination, Navigation]}
                        className="mySwiper"
                    >
                        {slides.map((slide, index) => (
                            <SwiperSlide key={index}>
                                <img src={slide.image_url} alt={`Slide ${index + 1}`}/>
                            </SwiperSlide>
                        ))}
                    </Swiper>
                </section>

                <section className="text-zinc-600 body-font">
                    <div className="container px-5 py-24 mx-auto">
                        <div className="text-center w-full mb-10">
                            <h1 className="sm:text-3xl text-2xl font-medium title-font mb-4 text-zinc-900">
                                Öne Çıkan Etkinlikler
                            </h1>
                        </div>
                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            {events.map((event) => (
                                <div
                                    key={event.id}
                                    className="flex flex-col max-w-sm bg-white border border-zinc-200 rounded-lg shadow">
                                    <Link href={`/events/${event.id}`} className="flex-shrink-0">
                                    <img className="rounded-t-lg w-full" src={`storage/${event.img}`}
                                             alt={event.name}/>
                                    </Link>
                                    <div className="flex flex-col flex-grow p-5">
                                        <Link href={`/events/${event.id}`} className="mb-2">
                                            <h5 className="text-2xl font-bold tracking-tight text-zinc-900">
                                                {event.name}
                                            </h5>
                                        </Link>
                                        <div className="flex-grow">
                                            <p className="mb-3 font-normal text-zinc-700">
                                                📍{event?.city?.name}
                                            </p>
                                        </div>
                                        <Link href={`/events/${event.id}`} className="mt-3">
                                            <Button type="button" label="Etkinliği incele" className="w-full"/>
                                        </Link>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                <section className="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div
                        className="relative bg-cover bg-[url('https://kommunity.com/img/cta1.jpg')] w-full h-80 md:h-full">
                        <div className="absolute inset-0 bg-black opacity-50"></div>
                        <div
                            className="relative flex flex-col items-center md:items-start justify-center px-5 py-7 h-full">
                            <StarIcon className="w-14 h-14 lg:w-22 lg:h-22 text-white mb-4"/>
                            <h3 className="text-xl text-white md:text-2xl font-semibold mb-2">
                                Codenteq'i ziyaret edin
                            </h3>
                            <p className="text-sm text-zinc-300 md:text-base">
                                {'Açık kaynak topluluğumuzu ziyaret edin.'}
                            </p>
                            <a
                                className="text-sm text-white md:text-base underline mt-2"
                                href="https://codenteq.com"
                                target="_blank"
                            >
                                Ziyaret et
                            </a>
                        </div>
                    </div>
                    <div
                        className="relative bg-cover bg-[url('https://kommunity.com/img/cta2.jpg')] w-full h-80 md:h-full">
                        <div className="absolute inset-0 bg-black opacity-50"></div>
                        <div
                            className="relative flex flex-col items-center md:items-start justify-center px-5 py-7 h-full">
                            <HeartIcon className="w-14 h-14 lg:w-22 lg:h-22 text-white mb-4"/>
                            <h3 className="text-xl text-white md:text-2xl font-semibold mb-2">
                                İmtihan
                            </h3>
                            <p className="text-sm text-zinc-300 md:text-base">
                                {'Eğitim hayatınızı kolaylaştıran pratik bir platform.'}
                            </p>
                            <a
                                className="text-sm text-white md:text-base underline mt-2"
                                href="https://imtihantech.com"
                                target="_blank"
                            >
                                Ziyaret et
                            </a>
                        </div>
                    </div>
                </section>
            </MainLayout>
        </>
    )
}
