import React, {useEffect, useState} from 'react';
import Step1 from "./steps/step1.jsx";
import Step2 from "./steps/step2.jsx";
import Step3 from "./steps/step3.jsx";
import Step4 from "./steps/step4.jsx";
import Step5 from "./steps/step5.jsx";
import {ChevronDoubleRightIcon} from "@heroicons/react/24/outline/index.js";
import {useForm, usePage} from "@inertiajs/react";
import MainLayout from "../Layouts/MainLayout.jsx";
import toast from "react-hot-toast";
import {HeartIcon, StarIcon} from "@heroicons/react/24/outline/index.js";
import {Accordion, AccordionBody, AccordionHeader, AccordionList, Button} from "@codenteq/interfeys";

export default function EventApplicationForm({cities, event, application = null}) {
    const [step, setStep] = useState(1);
    const {errors, flash} = usePage().props

    const form = useForm({
        full_name: application?.user?.name || null,
        email: application?.user?.email || null,
        phone: application?.user?.phone || null,
        birth_date: new Date(application?.user?.birth_date).getFullYear() || null,
        job: application?.job || null,
        city_id: application?.city_id || null,
        transportation: application?.transportation || null,
        participants: [],
        dont_camping_equipment: application?.dont_camping_equipment || false,
        tent: application?.tent || null,
        sleeping_bag: application?.sleeping_bag || null,
        mat: application?.mat || null,
        chair: application?.chair || null,
        telescope: application?.telescope || 0,
        telescope_brand: application?.telescope_brand || null,
        swaddling: application?.swaddling || 0,
        swaddling_brand: application?.swaddling_brand || null,
        binocular: application?.binocular || 0,
        camera: application?.camera || 0,
        tripod: application?.tripod || 0,
        walkie_talkie: application?.walkie_talkie || 0,
        computer: application?.computer || 0,
        arrival_date: application?.arrival_date || null,
        departure_date: application?.departure_date || null,
        event_id: event.id
    })


    const handleNext = () => {
        setStep(step + 1);
    };

    const handlePrev = () => {
        setStep(step - 1);
    };


    async function submit(e) {
        e.preventDefault()
        if (application) {
            form.put('/applications/' + application.id, {
                data: form.data,
                onError: () => {
                    toast.error('Bir hata oluştu. Lütfen tekrar deneyin.')
                }
            })
        } else {
            form.post('/applications/' + event.id, {
                data: form.data,
                onError: () => {
                    toast.error('Bir hata oluştu. Lütfen tekrar deneyin.')
                }
            })
        }
    }

    function checkIn() {
        form.patch(`/applications/${application.id}/check-in`, {
            onError: () => {
                toast.error('Bir hata oluştu. Lütfen tekrar deneyin.')
            }
        })
    }

    useEffect(() => {
        if (application) {
            application?.children?.map((child) => {
                form.data.participants.push({
                    id: child.id,
                    full_name: child.full_name,
                    birth_date: new Date(child.birth_date).getFullYear()
                })
            });
        }
    }, [application]);

    useEffect(() => {
        const validParticipants = form.data.participants.filter(participant => {
            console.log(participant.full_name, participant.birth_date);
            return participant.full_name !== '' && participant.birth_date !== '';
        });

        form.setData('participants', validParticipants);
    }, [step]);

    useEffect(() => {
        console.log(application);
    }, []);


    return (
        <MainLayout>
            <section className="max-w-4xl mx-auto my-10 px-4">
                <div className="py-10 text-center">
                    <h3 className="text-2xl lg:text-4xl font-bold text-zinc-900 dark:text-zinc-50">
                        {event.name}
                    </h3>
                </div>
            </section>

            <section className="max-w-4xl mx-auto bg-white rounded-lg p-4 shadow-md mb-8">
                <ol className="flex justify-between mb-6">
                    {[1, 2, 3, 4, 5].map((index) => (
                        <li key={index} className="w-full flex items-center justify-center">
                            <div
                                onClick={() => setStep(index)}
                                className={`rounded-full h-8 w-8 flex items-center cursor-pointer justify-center ${step === index ? 'bg-blue-400 text-white' : 'bg-gray-300'}`}>
                                <ChevronDoubleRightIcon className="w-4 h-4"/>
                            </div>
                        </li>
                    ))}
                </ol>

                <div>
                    <ol className="text-red-600">
                        {Object.entries(errors).map(([key, value], index) => (
                            <li key={index}>{value}</li>
                        ))}
                    </ol>
                </div>

                <form onSubmit={submit} className="flex flex-col gap-y-11">
                    <div>
                        {step === 1 && <Step1 data={form.data} setData={form.setData} cities={cities}/>}
                        {step === 2 && <Step2 data={form.data} setData={form.setData}/>}
                        {step === 3 && <Step3 data={form.data} setData={form.setData}/>}
                        {step === 4 && <Step4 data={form.data} setData={form.setData}/>}
                        {step === 5 && <Step5 data={form.data} setData={form.setData} event={event}/>}
                    </div>

                    <div className={`flex items-center ${step !== 1 ? 'justify-between' : 'justify-end'}`}>
                        {step !== 1 && <Button type="button" label="Geri" onClick={handlePrev}/>}
                        {step !== 5 && <Button type="button" label="Sonraki" onClick={handleNext}/> }
                        {!application && step === 5 && <Button type="submit" label="Başvuruyu Tamamla"/>}
                    </div>
                    {application && <Button type="submit" label="Check In Onayla"/>}
                </form>
{/*                {application && (
                    <div className="flex flex-col gap-5 justify-center mt-10 mb-10">
                        <p className="text-center">Eğer bilgilerinizde bir değişiklik var ise yukarıdaki form'dan
                            bilgilerinizi
                            güncelleyiniz. Bilgilerinizde bir değişiklik yoksa aşağıdaki butonu kullanaraks hızlı onay
                            yapabilirsiniz. </p>
                        <Button type="button" label="Check In Onayla" onClick={checkIn}/>
                    </div>
                )}*/}
            </section>

            {/*            <section className="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div className="relative bg-cover bg-[url('https://kommunity.com/img/cta1.jpg')] w-full h-80 md:h-full">
                    <div className="absolute inset-0 bg-black opacity-50"></div>
                    <div className="relative flex flex-col items-center md:items-start justify-center px-5 py-7 h-full">
                        <StarIcon className="w-14 h-14 lg:w-22 lg:h-22 text-white mb-4"/>
                        <h3 className="text-xl text-white md:text-2xl font-semibold mb-2">Codenteq'i ziyaret edin</h3>
                        <p className="text-sm text-zinc-300 md:text-base">Açık kaynak topluluğumuzu ziyaret edin.</p>
                        <a href="https://codenteq.com" target="_blank"
                           className="text-sm text-white md:text-base underline mt-2">Ziyaret et</a>
                    </div>
                </div>
                <div className="relative bg-cover bg-[url('https://kommunity.com/img/cta2.jpg')] w-full h-80 md:h-full">
                    <div className="absolute inset-0 bg-black opacity-50"></div>
                    <div className="relative flex flex-col items-center md:items-start justify-center px-5 py-7 h-full">
                        <HeartIcon className="w-14 h-14 lg:w-22 lg:h-22 text-white mb-4"/>
                        <h3 className="text-xl text-white md:text-2xl font-semibold mb-2">İmtihan</h3>
                        <p className="text-sm text-zinc-300 md:text-base">Eğitim hayatınızı kolaylaştıran pratik bir
                            platform.</p>
                        <a href="https://imtihantech.com" target="_blank"
                           className="text-sm text-white md:text-base underline mt-2">Ziyaret et</a>
                    </div>
                </div>
            </section>*/}

            <section className="max-w-4xl mx-auto my-8 p-4">
                <div className="bg-white rounded-lg shadow-md p-6">
                    <h2 className="text-2xl font-bold text-gray-800 mb-4">Sıkça Sorulan Sorular</h2>
                    <div className="space-y-4">
                        <AccordionList>
                            <Accordion>
                                <AccordionHeader>
                                    Etkinliğe nasıl başvurabilirim?
                                </AccordionHeader>
                                <AccordionBody>
                                    Etkinliğe başvurmak için genellikle etkinlik sayfasında bulunan başvuru formunu
                                    doldurmanız gerekmektedir. Başvuru formunda gerekli bilgileri eksiksiz olarak
                                    doldurduktan sonra başvurunuz tamamlanmış olacaktır.
                                </AccordionBody>
                            </Accordion>
                            <Accordion>
                                <AccordionHeader>
                                    Başvurumu ne zaman yapmalıyım?
                                </AccordionHeader>
                                <AccordionBody>
                                    Etkinlik başvuruları genellikle belirli bir tarihe kadar açıktır. Bu tarih, etkinlik
                                    sayfasında veya başvuru formunda belirtilir. Başvuru tarihini kaçırmamak için
                                    belirtilen tarihe kadar başvurunuzu tamamlamanız önemlidir.
                                </AccordionBody>
                            </Accordion>
                            <Accordion>
                                <AccordionHeader>
                                    Başvurum onaylandığında ne olacak?
                                </AccordionHeader>
                                <AccordionBody>
                                    Başvurunuz onaylandığında genellikle bir onay e-postası alırsınız. Bu e-postada
                                    başvurunuzun onaylandığı ve etkinlikle ilgili önemli bilgilerin bulunduğu
                                    belirtilir.
                                </AccordionBody>
                            </Accordion>
                            <Accordion>
                                <AccordionHeader>
                                    Katılım için gerekenler nelerdir?
                                </AccordionHeader>
                                <AccordionBody>
                                    Katılım için genellikle kayıt yapılması gerekmektedir. Bazı etkinlikler belirli bir
                                    yaş sınırı veya tecrübe gerektirebilir. Ayrıntılı bilgi etkinlik sayfasında yer
                                    almaktadır.
                                </AccordionBody>
                            </Accordion>
                            <Accordion>
                                <AccordionHeader>
                                    Başvurum reddedilirse ne yapmalıyım?
                                </AccordionHeader>
                                <AccordionBody>
                                    Başvurunuzun reddedilmesi durumunda genellikle size bir geri bildirim iletilir. Geri
                                    bildirimde neden başvurunuzun reddedildiği ve gerekirse yeniden başvuru
                                    yapabileceğiniz
                                    bilgisi yer alır. Başvurunuzun reddedilmesi durumunda organizatörlerle iletişime
                                    geçerek daha fazla bilgi alabilirsiniz.
                                </AccordionBody>
                            </Accordion>
                        </AccordionList>
                    </div>
                </div>
            </section>
        </MainLayout>
    );
}
