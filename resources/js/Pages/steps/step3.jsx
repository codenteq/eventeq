import {Input, Label} from "@codenteq/interfeys";
import React, {useEffect, useState} from "react";

export default function Step3({data, setData}) {
    const [dontCampingEquipment, setDontCampingEquipment] = useState(data.dont_camping_equipment);

    const handleDontCampingEquipmentChange = (event) => {
        setData('dont_camping_equipment', event.target.checked)
        setDontCampingEquipment(event.target.checked);
    };

    useEffect(() => {
        console.log(data.dont_camping_equipment);
        setDontCampingEquipment(data.dont_camping_equipment);
    }, []);

    return (
        <>
            <div className="my-5">
                <h3>Adım 3: Kamp Malzemesi İhtiyaçları</h3>
                <p className="mb-3">
                    Kamp malzemesi fiyatlarını Organizasyon İletişim Linki üzerinden ulaşarak sorarak ayırtmanız
                    gerekmektedir. Bu formda yazacağınız ihtiyaç listesi organizasyonun sağlıklı işlemesi açısından
                    önemlidir. Lütfen ihtiyaç listenizi belirtip iletişim kanallarından rezervasyon yaptırınız.
                </p>
                <a href="https://sites.google.com/view/skyisderman/ileti%C5%9Fim?authuser=0"
                   className="text-blue-300" target="_blank">https://sites.google.com/view/skyisderman/ileti%C5%9Fim?authuser=0</a>
            </div>
            <div>
                <div className="flex items-center gap-3 mb-6">
                    <Input
                        name="dont_camping_equipment"
                        id="dont_camping_equipment"
                        type="checkbox"
                        checked={dontCampingEquipment}
                        onChange={handleDontCampingEquipmentChange}
                    />
                    <Label htmlFor="dont_camping_equipment">
                        Kamp malzemelerini (Çadır, sandalye, tulum vb.),
                        uygun bir fiyata kamp alanından temin etmek ister misiniz?
                    </Label>
                </div>

                {dontCampingEquipment && (
                    <div className="grid gap-5 mb-6 lg:grid-cols-2">
                        <Input
                            name="tent"
                            value={data.tent}
                            onChange={(e) => setData('tent', e.target.value)}
                            type="number"
                            min={0}
                            label="Çadır"
                            helpText="Kaç adet çadır ihtiyacınız var?"
                            className="block w-full"
                        />
                        <Input
                            name="sleeping_bag"
                            value={data.sleeping_bag}
                            onChange={(e) => setData('sleeping_bag', e.target.value)}
                            type="number"
                            min={0}
                            label="Uyku tulumu"
                            helpText="Kaç adet uyku tulumu ihtiyacınız var?"
                            className="block w-full"
                        />
                        <Input
                            name="Mat"
                            value={data.mat}
                            onChange={(e) => setData('mat', e.target.value)}
                            type="number"
                            min={0}
                            label="Mat"
                            helpText="Kaç adet mat ihtiyacınız var?"
                            className="block w-full"
                        />
                        <Input
                            name="chair"
                            value={data.chair}
                            onChange={(e) => setData('chair', e.target.value)}
                            type="number"
                            min={0}
                            label="Sandalye"
                            helpText="Kaç adet sandalye ihtiyacınız var?"
                            className="block w-full"
                        />
                    </div>
                )}
            </div>
        </>
    )
}
