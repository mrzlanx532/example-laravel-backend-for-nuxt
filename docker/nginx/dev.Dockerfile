FROM nginx:stable

RUN echo "alias ll='ls -la'" >> ~/.bashrc

ARG LOCAL_LINUX_USER
ARG LOCAL_LINUX_USER_UID

RUN useradd -m ${LOCAL_LINUX_USER} --uid=${LOCAL_LINUX_USER_UID}

RUN sed -i "s/user  nginx;/user ${LOCAL_LINUX_USER};/g" /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]