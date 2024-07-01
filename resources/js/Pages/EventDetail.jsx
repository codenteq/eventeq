import React from 'react';
import MainLayout from "../Layouts/MainLayout.jsx";
import { Button } from "@codenteq/interfeys";
import { Link } from "@inertiajs/react";
import { format } from "date-fns";
import { tr } from 'date-fns/locale';

export default function EventDetail({ event }) {
    const formatDate = (dateString) => {
        return format(new Date(dateString), "d MMMM yyyy", { locale: tr });
    };

    return (
        <MainLayout>
            <section className="text-gray-600 body-font relative">
                <div className="container px-5 py-12 mx-auto">
                    <div className="flex flex-col md:flex-row justify-center md:space-x-12">
                        <div className="md:w-1/2 relative">
                            <div className="sticky top-16">
                                <img className="rounded-lg w-full mb-8 md:mb-0" src={`/storage/${event.img}`}
                                     alt={event.name}/>
                            </div>
                        </div>
                        <div className="md:w-1/2 flex flex-col justify-center">
                            <h3 className="mb-8 text-2xl lg:text-4xl font-semibold leading-tight text-center md:text-left">
                                {event.name}
                            </h3>
                            <p className="text-lg lg:text-xl text-zinc-900 dark:text-zinc-100 leading-relaxed mb-8"
                               dangerouslySetInnerHTML={{__html: event.description}}
                            />
                            <div className="flex flex-col space-y-6 md:flex-row md:space-x-6 md:space-y-0">
                                <div className="flex-1">
                                    <h2 className="text-gray-900 text-lg mb-1 font-medium title-font">Etkinlik Tarihi</h2>
                                    <p className="leading-relaxed text-gray-600">
                                        {formatDate(event.start_date)} - {formatDate(event.end_date)}
                                    </p>
                                </div>
                                <div className="flex-1">
                                    <h2 className="text-gray-900 text-lg mb-1 font-medium title-font">Şehir</h2>
                                    <p className="leading-relaxed text-gray-600">
                                        {event.city.name}
                                    </p>
                                </div>
                            </div>
                            <Link href={`/applications/${event.id}`} className="mt-8">
                                <Button type="button" label="Başvur" className="w-full"/>
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </MainLayout>
    )
}
